function calldatemonthyearMy(textboxid,divspanid,mindateymd,maxdateymd)
{
    
    var mindateymdAr=mindateymd.split("-");
    var mindateyear=parseInt(mindateymdAr[0]);
    var mindatemonth=parseInt(mindateymdAr[1]);
    var mindateday=parseInt(mindateymdAr[2]);
    
    var maxdateymdAr=maxdateymd.split("-");
    var maxdateyear=parseInt(maxdateymdAr[0]);
    var maxdatemonth=parseInt(maxdateymdAr[1]);
    var maxdateday=parseInt(maxdateymdAr[2]);
 
    //jQuery(document).ready(function(){
        jQuery(textboxid).dayMonthYearCalendar({
          container: jQuery(divspanid)
          , hideInput: true
          , monthNames: jQuery.datepicker._defaults.monthNames
          , minDate: new Date(mindateyear, mindatemonth, mindateday)
          , maxDate: new Date()
          , dateFormatFunction: function(date) {
          return jQuery.datepicker.formatDate('MM d, yy',date);
          }
          , dateParseFunction: function(dateString) {
          return moment(dateString, 'MMM D, YYYY').toDate();
          }
            ,monthsClass:'selectWrap adj-width-custom month-pickerWidth'
            ,daysClass:'selectWrap adj-width-custom date-pickerWidth'
            ,yearsClass:'selectWrap adj-width-custom year-pickerWidth'
           
            ,daysEmptyText:"Day"
            ,monthsEmptyText:"Month"
            ,yearsEmptyText:"Year"
          });
    //});
     
       var yyyobj= $('#dobYears').selectpicker();
       var mmmobj=$('#dobMonths').selectpicker();
       var dddobj=$('#dobDays').selectpicker();
     
        
      
       
       yyyobj.on('hidden.bs.select', function (e) {
            
                mmmobj.selectpicker('refresh');
                dddobj.selectpicker('refresh');
        });
        
        mmmobj.on('hidden.bs.select', function (e) {
            
                dddobj.selectpicker('refresh');
        });
}