//From work done by kaljade
//https://www.homebrewtalk.com/forum/threads/keg-volume-calculator.633022/#post-8486983
//https://www.homebrewtalk.com/forum/threads/version-2-release-raspberrypints-digital-taplist-solution.487694/page-98#post-8479841
function getWeightByVol(volume, emptyWeight, temperature, altitude, beerCO2PSI, convertToMetric, finalGravity, convertToGravity)
{
	//convertToMetric means the values given are imperial and not metric already.
	//convertToGravity means the values given are Plato and not gravity already.
	estVolume = volume;																			//Volume of keg passed in
	if(convertToMetric) estVolume = parseFloat(estVolume)/0.264172052;							//Convert volume to Liters if in Gallons
	emptyWeight = parseFloat(emptyWeight);														//Empty Keg weight passed in
	if(!convertToMetric) emptyWeight = emptyWeight*2.2046226218									//Convert to lbs if given kgs
	estGrav = parseFloat(finalGravity);															//Final gravity of the beer passed in
	if(convertToGravity) estGrav = 259/(259-estGrav);											//Convert to gravity if in Plato                                                                                                                    
	beerCO2PSI = parseFloat(beerCO2PSI);														//Beer pressure passed in
	if(!convertToMetric) beerCO2PSI = beerCO2PSI*.145038											//Convert to PSI if in kPa
	
	estLocalPress = estPressureAtAltitude(altitude, convertToMetric);							//Barometric pressure based on altitude (m) in PSI              
	estPress = ((estLocalPress+beerCO2PSI)*0.0680459639);										//Estimated absolute pressure in atmospheres
	estH2OMass = estWaterDensity(getTempCelsius(temperature, convertToMetric));					//Estimated mass of pure water at temp supplied
	estH2OMassPress = ((estH2OMass/(1-((estPress*101325)-101325)/215e7)));						//Estimated mass of pure water adjusted for pressure
	estCO2Vol = deLangeEquation(estLocalPress, beerCO2PSI, temperature, convertToMetric);		//Estimated Volumes of CO2 in the beer																																
	estGravVariance = (((estGrav-1.015)*1000)/3);												//Estimated gravity variance for final gravity
	estCO2Grav = (estCO2Vol*(estGravVariance/100));												//Estimated CO2 adjusted for garvity variance
	estCO2GPL = ((estCO2Vol-estCO2Grav)*1.96);													//Estimated grams per litre of CO2
	estBeerWeight = (((estH2OMassPress*estGrav)*estVolume)*2.2046226218);						//Estimated weight of beer based on final gavity
	estCO2 = ((estCO2GPL*estVolume)*0.001);														//Estimated weight of CO2 in kilograms
	estCO2US = (estCO2*2.2046226218);															//Estimated weight of CO2 in pounds
	estWeight = (emptyWeight+estBeerWeight+estCO2US).toFixed(4);	
	
	return estWeight*(convertToMetric?1:2.2046226218);
}

function getVolumeByWeight(weight, emptyWeight, temperature, altitude, beerCO2PSI, convertToMetric, finalGravity, convertToGravity)
{
	//convertToMetric means the values given are imperial and not metric already.
	//convertToGravity means the values given are Plato and not gravity already.
	weight = parseFloat(weight);																	//Weight of keg with beer passed in
	if(convertToMetric) weight =  (weight/2.2046226218);											//Convert to kg if in lb
	emptyWeight = parseFloat(emptyWeight);															//Empty weight of selected keg passed in
	if(convertToMetric) emptyWeight =  (emptyWeight/2.2046226218);									//Convert to kg if in lb
	actGrav = parseFloat(finalGravity);																//Final gravity of the beer passed in
	if(convertToGravity) actGrav = 259/(259-actGrav);												//Convert to gravity if in Plato                                                                                                                     
	beerCO2PSI = parseFloat(beerCO2PSI);															//Beer pressure passed in
	if(!convertToMetric) beerCO2PSI = beerCO2PSI*.145038											//Convert to PSI if in kPa
	
	actLocalPress = estPressureAtAltitude(altitude, convertToMetric);								//Barometric pressure based on altitude in PSI
	actPress = ((actLocalPress+beerCO2PSI)*0.0680459639);											//Actual absolute pressure in atmospheres
	actH2OMass = estWaterDensity(getTempCelsius(temperature, convertToMetric));						//Estimated mass of pure water at temp supplied
	actH2OMassPress = ((actH2OMass/(1-((actPress*101325)-101325)/215e7)));							//Actual mass of pure water adjusted for pressure
	actCO2Vol = deLangeEquation(actLocalPress, beerCO2PSI, temperature, convertToMetric);			//Estimated Volumes of CO2 in the beer
	actBeerWeight = ((weight-emptyWeight)/actGrav);													//Estimated weight of beer based on final gravity
	actBeerVol = (actBeerWeight/actH2OMassPress);													//Estimated volume of beer based on final gravity
	actGravVar = (((actGrav-1.015)*1000)/3);														//Actual CO2 variance for final gravity
	actCO2Grav = (actCO2Vol*(actGravVar/100));														//Actual CO2 adjusted for garvity variance
	actCO2GPL = ((actCO2Vol-actCO2Grav)*1.96);														//Actual grams per litre of CO2
	actCO2 = ((actCO2GPL*actBeerVol)*0.001);														//Actual weight of CO2 in kilograms
	actBeerWeightCO2 = (((weight-actCO2)-emptyWeight)/actGrav);										//Actual weight of beer adjusted for CO2
	actVolume = ((actBeerWeightCO2/actH2OMassPress)*(!convertToMetric?0.264172052:1)).toFixed(3);	//Actual volume of beer in units requested
	
	//if we need to convert the arguments to metric then we need to convert metric to imperial in the return value
	return actVolume*(convertToMetric?0.264172052:1);
}		

function estPressureAtAltitude(altitude, convertToMetric){
	altitude = parseFloat(altitude);
	if(convertToMetric) altitude = (altitude)*0.3048;										//Convert altitude to meters if in feet    
	return ((Math.pow((288.15/((288.15+(-65e-4)*(altitude)))),((9.80665*0.0289644)/(8.3144598*(-65e-4)))))*14.6959487755142);
}
function deLangeEquation(localPsi, beerPsi, temperature, convertToMetric){
	return (localPsi+beerPsi)*(0.01821+(0.090115*(Math.exp(-(getTempImperial(temperature, convertToMetric)-32)/43.11))))-3342e-6
}
function estWaterDensity(tempCel){
	tempCel = parseFloat(tempCel);
	return (0.99984+tempCel*(6.7715e-5-tempCel*(9.0735e-6-tempCel*(1.015e-7-tempCel*(1.3356e-9-tempCel*(1.4421e-11-tempCel*(1.0896e-13-tempCel*(4.9038e-16-9.7531e-19*tempCel))))))));
}

function getTempImperial(temp, convertToMetric){
	temp = parseFloat(temp);
	//if needing convert to metric we are in farenheit return as is
	if(convertToMetric) return temp;
	return ((temp*9)/5)+32;
}
function getTempCelsius(temp, convertToMetric){
	temp = parseFloat(temp);
	//if NOT needing convert to metric we are in metric return as is
	if(!convertToMetric) return temp;
	return ((temp-32)*5)/9;
}