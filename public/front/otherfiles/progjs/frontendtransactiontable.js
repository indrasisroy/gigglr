
       function payTableScoll() {
           // Change the selector if needed
           var $table = $('table.payTable'),
               $bodyCells = $table.find('tbody tr:first').children(),
               colWidth;

               colWidth = $bodyCells.map(function() {
                   return $(this).width();
               }).get();

               // Set the width of thead columns
               $table.find('thead tr').children().each(function(i, v) {
                   $(v).width(colWidth[i]);
               });  
               $table.find('tfoot tr').children().each(function(i, v) {
                   $(v).width(colWidth[i]);
               });
               $table.find('tbody tr').children().each(function(i, v) {
                   $(v).width(colWidth[i]);
               });
          
       }
       $(window).load(function(){
           payTableScoll();
           
           var tRw = $('.payTable tbody tr').size();
           if (tRw > 1) {
               $('.payTable').addClass('historyTable');
           }
           
       });
       $(window).resize(function(){
           payTableScoll();
       });
       $(document).click(function(){
           setTimeout(function(){
               payTableScoll();
           }, 200);
           
       });
    