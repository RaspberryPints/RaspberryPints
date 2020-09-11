These files contain SVG path elements to render the various components
of the container.  The renderer applies style to 4 distinct elements:

  1) outline - An outline of the container.  Add gradientto make shadows
  2) liquid - The liquid component.  The render applies the rgb estimate
     of the srm value to this component.
  3) liquid_lighten - The lower portion of the liquid that gives it a lighter shade
  4) foam - The foam or head.  The renderer crudely applies 3 shades of 
     color to the foam based on the red value of the above rgb component.
  5) glass_right - Shading on the right side of the glass
  6) glass_left  - Shading on the Left side of the glass
  7) glass_bottom - the circle on the bottom of the glass to give some depth to it
  8) glass_glare - the line of glare on the glass from light source.

You can add other containers by drawing these 8 paths in your favorite SVG
editor, then manually editing out all the containing metadata.  Set the id 
of each path as defined above and be sure to remove any style information.
