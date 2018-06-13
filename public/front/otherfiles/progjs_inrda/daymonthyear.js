function calldatemonthyear(textboxid,divspanid,mindateymd,maxdateymd)
{
    
    var mindateymdAr=mindateymd.split("-");
    var mindateyear=parseInt(mindateymdAr[0]);
    var mindatemonth=parseInt(mindateymdAr[1]);
    var mindateday=parseInt(mindateymdAr[2]);
    
    var maxdateymdAr=maxdateymd.split("-");
    var maxdateyear=parseInt(maxdateymdAr[0]);
    var maxdatemonth=parseInt(maxdateymdAr[1]);
    var maxdateday=parseInt(maxdateymdAr[2]);
    
     // alert("=maxdateyear=>"+maxdateyear);
    //alert("=maxdateyear=>"+maxdateyear);
    
   
    
    
     jQuery(textboxid).dayMonthYearCalendar({
      container: jQuery(divspanid)
      , hideInput: true
      , monthNames: jQuery.datepicker._defaults.monthNames
      , minDate: new Date(mindateyear, mindatemonth, mindateday)
      , maxDate: new Date()
      , dateFormatFunction: function(date) {
      // date -> string
      return jQuery.datepicker.formatDate('MM d, yy',date);
      }
      , dateParseFunction: function(dateString) {
      // string -> date
      //var tt=moment(dateString, 'MMM D, YYYY').toDate();
      //console.log(tt);
      return moment(dateString, 'MMM D, YYYY').toDate();
      }
      ,monthsClass:'selectWrap extra-width mycustommonthclass'
        ,daysClass:'selectWrap adj-width mycustomdayclass'
        ,yearsClass:'selectWrap extra-width mycustomyearclass'
       
        ,daysEmptyText:"Day"
        ,monthsEmptyText:"Month"
        ,yearsEmptyText:"Year"
        
      
      
      });
     
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