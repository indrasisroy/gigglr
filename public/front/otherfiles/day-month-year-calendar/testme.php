<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description" content="day-month-year-calendar : calendar, date picker, three select boxes">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- <link rel="stylesheet" type="text/css" media="screen" href="day-month-year-calendar_files/stylesheet.css">
    <link rel="stylesheet" type="text/css" media="screen" href="day-month-year-calendar_files/prism.css">-->

    <title>day-month-year-calendar</title>
  </head>

  <body>


    <!-- MAIN CONTENT -->
    <div id="main_content_wrap" class="outer">
      <section id="main_content" class="inner">
        <h1 id="project_title">day-month-year-calendar</h1>
<!--        <div id="project_description"> 
          <h5>It is a jQuery plugin that creates three select boxes (day, month, year) for one input field with date</h5>
          <a id="download" href="https://github.com/Qwertovsky/day-month-year-calendar/releases">Download</a>
          <a id="forkme_banner" href="https://github.com/Qwertovsky/day-month-year-calendar">View on GitHub</a>
        </div>
-->
<h3>Usages</h3>
<p>Next example shows input and calendar. Changes on calendar affect input value.</p>



<p>You can set minimum and maximum values for date.</p>
<h3>Options</h3>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Default</th>
      <th class="hide_small">Type</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>minDate</td>
      <td>today - 100 years</td>
      <td class="hide_small">Date</td>
      <td>Minimum date is enabled for choose</td>
    </tr>
    <tr>
      <td>maxDate</td>
      <td>today + 100 years</td>
      <td class="hide_small">Date</td>
      <td>Maximum date is enabled for choose</td>
    </tr>
    <tr>
      <td>monthNames</td>
      <td>1..12</td>
      <td class="hide_small">Array of String</td>
      <td>Array of months for options</td>
    </tr>
    <tr>
      <td>daysClass</td>
      <td>dmy-cal-days</td>
      <td class="hide_small">String</td>
      <td>Style class for day select</td>
    </tr>
    <tr>
      <td>monthsClass</td>
      <td>dmy-cal-months</td>
      <td class="hide_small">String</td>
      <td>Style class for month select</td>
    </tr>
    <tr>
      <td>yearsClass</td>
      <td>dmy-cal-years</td>
      <td class="hide_small">String</td>
      <td>Style class for year select</td>
    </tr>
    <tr>
      <td>daysEmptyText</td>
      <td>dd</td>
      <td class="hide_small">String</td>
      <td>Empty option text for day select</td>
    </tr>
    <tr>
      <td>monthsEmptyText</td>
      <td>mm</td>
      <td class="hide_small">String</td>
      <td>Empty option text for month select</td>
    </tr>
    <tr>
      <td>yearsEmptyText</td>
      <td>yyyy</td>
      <td class="hide_small">String</td>
      <td>Empty option text for year select</td>
    </tr>
    <tr>
      <td>hideInput</td>
      <td>true</td>
      <td class="hide_small">Boolean</td>
      <td>Hide input text field</td>
    </tr>
    <tr>
      <td>dateFormatFunction</td>
      <td>dd.mm.yyyy</td>
      <td class="hide_small">Function (Date)</td>
      <td>Function that convert Date to String</td>
    </tr>
    <tr>
      <td>dateParseFunction</td>
      <td>dd.mm.yyyy</td>
      <td class="hide_small">Function (String)</td>
      <td>Function that convert String to Date</td>
    </tr>
  </tbody>
</table>
<?php

if(!empty($_POST))
{
   echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
   
   $dob=$_REQUEST['dob'];
   
   echo "formated=>". date("Y-m-d",strtotime($dob));
}

?>
<form action="" method="POST">
<div>
 <input type="text" name="dob" id="dob" value="<?php echo date("F d, Y"); ?>" >
 <span id="dobspanid"  ></span>
  
</div>
<div>
  <input type="submit" name="save" value="save" >
  
</div>
</form>

<h3>Requirements</h3>
<p>jQuery: &gt;=1.7.0</p>

      </section>
    </div>

    <!-- FOOTER  -->
    <div id="footer_wrap" class="outer">
      <footer class="inner">
        <p class="copyright">day-month-year-calendar maintained by <a href="http://qwertovsky.com/">Qwertovsky</a></p>
        <p>Published with <a href="https://github.com/Qwertovsky">GitHub</a></p>
      </footer>
    </div>

        <script type="text/javascript" src="day-month-year-calendar_files/jquery.js"></script>
        <!--<script type="text/javascript" src="day-month-year-calendar_files/prism.js"></script>-->
        <script type="text/javascript" src="day-month-year-calendar_files/day-month-year-calendar.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/datepicker.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/moment.js"></script>
        <!--<script type="text/javascript" src="day-month-year-calendar_files/main.js"></script>-->
        
        <script>
          
          jQuery(document).ready(function(){
            
//            $('#dob').dayMonthYearCalendar({ 
//    container: $('#dobspanid')
//    , hideInput: false
//    , monthNames: $.datepicker._defaults.monthNames
//    ,monthsClass:'dob_month_class'
//    ,daysClass:'dob_day_class'
//     ,yearsClass:'dob_year_class'
//     ,maxDate:new Date(2016, 12, 31)
//     , dateFormatFunction: function(date) {
//      // date -> string
//      return $.datepicker.formatDate('yy-mm-d',date);
//    }
//     , dateParseFunction: function(dateString) {
//      // string -> date
//      return moment(dateString, 'dd.mm.yy').toDate();
//    }
//   
//     
//});
      
      
     //**** now starts
     
      $('#dob').dayMonthYearCalendar({
      container: $('#dobspanid')
      , hideInput: false
      , monthNames: $.datepicker._defaults.monthNames
      , minDate: new Date(1920, 1, 1)
      , maxDate: new Date(2016,12,31)
      , dateFormatFunction: function(date) {
      // date -> string
      return $.datepicker.formatDate('MM d, yy',date);
      }
      , dateParseFunction: function(dateString) {
      // string -> date
      //var tt=moment(dateString, 'MMM D, YYYY').toDate();
      //console.log(tt);
      return moment(dateString, 'MMM D, YYYY').toDate();
      }
      });
     
     //**** now ends
     
     
     
            
            
            });
        </script>
    

</body></html>