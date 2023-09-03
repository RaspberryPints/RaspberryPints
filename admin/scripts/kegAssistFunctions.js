//From work done by kaljade
//https://www.homebrewtalk.com/forum/threads/keg-volume-calculator.633022/#post-8486983
//https://www.homebrewtalk.com/forum/threads/version-2-release-raspberrypints-digital-taplist-solution.487694/page-98#post-8479841
function getWeightByVol(volume, volumeUnit, emptyWeight, emptyWeightUnit, temperature, temperatureUnit, altitude, altitudeUnit, beerCO2PSI, beerCO2PSIUnit, finalGravity, finalGravityUnit, returnUnit)
{
	estVolume = volume;																			//Volume of keg passed in
	if(volumeUnit != 'ml' && volumeUnit != 'l') estVolume = parseFloat(estVolume)/0.264172052;	//Convert volume to Liters if in Gallons
	emptyWeight = parseFloat(emptyWeight);														//Empty Keg weight passed in
	if(emptyWeightUnit == 'kg') emptyWeight = emptyWeight*2.2046226218							//Convert to lbs if given kgs
	estGrav = parseFloat(finalGravity);															//Final gravity of the beer passed in
	if(finalGravityUnit == 'p') estGrav = 259/(259-estGrav);									//Convert to gravity if in Plato     
	if(finalGravityUnit == 'b') estGrav = round((estGrav / (258.6-((estGrav / 258.2)*227.1))) + 1, 3);//Convert to gravity if in Brix                                                                                                                    
	beerCO2PSI = parseFloat(beerCO2PSI);														//Beer pressure passed in
	if(beerCO2PSIUnit != 'psi') beerCO2PSI = beerCO2PSI/6894.757;								//Convert to PSI if in kPa
	
	estLocalPress = estPressureAtAltitude(altitude, altitudeUnit);								//Barometric pressure based on altitude (m) in PSI              
	estPress = ((estLocalPress+beerCO2PSI)*0.0680459639);										//Estimated absolute pressure in atmospheres
	estH2OMass = estWaterDensity(getTempCelsius(temperature, temperatureUnit));					//Estimated mass of pure water at temp supplied
	estH2OMassPress = ((estH2OMass/(1-((estPress*101325)-101325)/215e7)));						//Estimated mass of pure water adjusted for pressure
	estCO2Vol = deLangeEquation(estLocalPress, beerCO2PSI, temperature, temperatureUnit);		//Estimated Volumes of CO2 in the beer																																
	estGravVariance = (((estGrav-1.015)*1000)/3);												//Estimated gravity variance for final gravity
	estCO2Grav = (estCO2Vol*(estGravVariance/100));												//Estimated CO2 adjusted for garvity variance
	estCO2GPL = ((estCO2Vol-estCO2Grav)*1.96);													//Estimated grams per litre of CO2
	estBeerWeight = (((estH2OMassPress*estGrav)*estVolume)*2.2046226218);						//Estimated weight of beer based on final gavity
	estCO2 = ((estCO2GPL*estVolume)*0.001);														//Estimated weight of CO2 in kilograms
	estCO2US = (estCO2*2.2046226218);															//Estimated weight of CO2 in pounds
	estWeight = (emptyWeight+estBeerWeight+estCO2US);	
	
	//Est weight is in pounds now, if return lbs return as is
	return estWeight/(returnUnit == 'lb'?1:2.2046226218);
}

function getVolumeByWeight(weight, weightUnit, emptyWeight, emptyWeightUnit, temperature, temperatureUnit, altitude, altitudeUnit, beerCO2PSI, beerCO2PSIUnit, finalGravity, finalGravityUnit, returnUnit)
{
	weight = parseFloat(weight);																	//Weight of keg with beer passed in
	if(weightUnit == 'lb') weight =  (weight/2.2046226218);											//Convert to kg if in lb
	emptyWeight = parseFloat(emptyWeight);															//Empty weight of selected keg passed in
	if(emptyWeightUnit == 'lb') emptyWeight =  (emptyWeight/2.2046226218);							//Convert to kg if in lb
	actGrav = parseFloat(finalGravity);																//Final gravity of the beer passed in
	if(finalGravityUnit == 'p') actGrav = 259/(259-actGrav);										//Convert to gravity if in Plato   
	if(finalGravityUnit == 'b') actGrav = round((actGrav / (258.6-((actGrav / 258.2)*227.1))) + 1, 3);//Convert to gravity if in Brix                                                                                                                        
	beerCO2PSI = parseFloat(beerCO2PSI);															//Beer pressure passed in
	if(beerCO2PSIUnit != 'psi') beerCO2PSI = beerCO2PSI/6894.757;									//Convert to PSI if in kPa
	
	actLocalPress = estPressureAtAltitude(altitude, altitudeUnit);									//Barometric pressure based on altitude in PSI
	actPress = ((actLocalPress+beerCO2PSI)*0.0680459639);											//Actual absolute pressure in atmospheres
	actH2OMass = estWaterDensity(getTempCelsius(temperature, temperatureUnit));						//Estimated mass of pure water at temp supplied
	actH2OMassPress = ((actH2OMass/(1-((actPress*101325)-101325)/215e7)));							//Actual mass of pure water adjusted for pressure
	actCO2Vol = deLangeEquation(actLocalPress, beerCO2PSI, temperature, temperatureUnit);			//Estimated Volumes of CO2 in the beer
	actBeerWeight = ((weight-emptyWeight)/actGrav);													//Estimated weight of beer based on final gravity
	actBeerVol = (actBeerWeight/actH2OMassPress);													//Estimated volume of beer based on final gravity
	actGravVar = (((actGrav-1.015)*1000)/3);														//Actual CO2 variance for final gravity
	actCO2Grav = (actCO2Vol*(actGravVar/100));														//Actual CO2 adjusted for garvity variance
	actCO2GPL = ((actCO2Vol-actCO2Grav)*1.96);														//Actual grams per litre of CO2
	actCO2 = ((actCO2GPL*actBeerVol)*0.001);														//Actual weight of CO2 in kilograms
	actBeerWeightCO2 = (((weight-actCO2)-emptyWeight)/actGrav);										//Actual weight of beer adjusted for CO2
	actVolume = (actBeerWeightCO2/actH2OMassPress);													//Actual volume of beer
	
	//act volume is in liters right now. if return is oz convert
	return (actVolume*(returnUnit == 'oz'?0.264172052:1));
}		

function estPressureAtAltitude(altitude, altitudeUnit){
	altitude = parseFloat(altitude);
	if(altitudeUnit == 'ft') altitude = (altitude)*0.3048;										//Convert altitude to meters if in feet    
	return ((Math.pow((288.15/((288.15+(-65e-4)*(altitude)))),((9.80665*0.0289644)/(8.3144598*(-65e-4)))))*14.6959487755142);
}
function deLangeEquation(localPsi, beerPsi, temperature, temperatureUnit){
	return (localPsi+beerPsi)*(0.01821+(0.090115*(Math.exp(-(getTempImperial(temperature, temperatureUnit)-32)/43.11))))-3342e-6
}
function estWaterDensity(tempCel){
	tempCel = parseFloat(tempCel);
	return (0.99984+tempCel*(6.7715e-5-tempCel*(9.0735e-6-tempCel*(1.015e-7-tempCel*(1.3356e-9-tempCel*(1.4421e-11-tempCel*(1.0896e-13-tempCel*(4.9038e-16-9.7531e-19*tempCel))))))));
}

function getTempImperial(temp, temperatureUnit){
	temp = parseFloat(temp);
	if(temperatureUnit == 'F') return temp;
	return ((temp*9)/5)+32;
}
function getTempCelsius(temp, temperatureUnit){
	temp = parseFloat(temp);
	if(temperatureUnit == 'C') return temp;
	return ((temp-32)*5)/9;
}