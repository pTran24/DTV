$(".resizable th").resizable({
 handles: "e",

 // set correct COL element and original size
 start: function(event, ui) {
   var colIndex = ui.helper.index() + 1;
   colElement = table.find("colgroup > col:nth-child(" +
     colIndex + ")");

  // get col width (faster than .width() on IE)
  colWidth = parseInt(colElement.get(0).style.width, 10);
  originalSize = ui.size.width;
 },

 // set COL width
 resize: function(event, ui) {
   var resizeDelta = ui.size.width - originalSize;

   var newColWidth = colWidth + resizeDelta;
   colElement.width(newColWidth);

   // height must be set in order to prevent IE9 to set wrong height
   $(this).css("height", "auto");
 }
});
