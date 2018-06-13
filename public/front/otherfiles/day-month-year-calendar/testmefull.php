<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description" content="day-month-year-calendar : calendar, date picker, three select boxes">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" media="screen" href="day-month-year-calendar_files/stylesheet.css">
    <link rel="stylesheet" type="text/css" media="screen" href="day-month-year-calendar_files/prism.css">

    <title>day-month-year-calendar</title>
  </head>

  <body>


    <!-- MAIN CONTENT -->
    <div id="main_content_wrap" class="outer">
      <section id="main_content" class="inner">
        <h1 id="project_title">day-month-year-calendar</h1>
        <div id="project_description"> 
          <h5>It is a jQuery plugin that creates three select boxes (day, month, year) for one input field with date</h5>
          <a id="download" href="https://github.com/Qwertovsky/day-month-year-calendar/releases">Download</a>
          <a id="forkme_banner" href="https://github.com/Qwertovsky/day-month-year-calendar">View on GitHub</a>
        </div>

<h3>Usages</h3>
<p>Next example shows input and calendar. Changes on calendar affect input value.</p>

<div id="example_1" class="example">
    <input value="22.04.2016" id="dateinput_1" class="example_input">
    <div class="selects_container"><div class="dmy-cal-days">    <select id="dateinput_1Days"><option value="0" disabled="disabled">dd</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option selected="selected" value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option></select></div><div class="dmy-cal-months">  <select id="dateinput_1Months"><option value="0" disabled="disabled">mm</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option selected="selected" value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></div><div class="dmy-cal-years">  <select id="dateinput_1Years"><option value="0" disabled="disabled">yyyy</option><option value="2116">2116</option><option value="2115">2115</option><option value="2114">2114</option><option value="2113">2113</option><option value="2112">2112</option><option value="2111">2111</option><option value="2110">2110</option><option value="2109">2109</option><option value="2108">2108</option><option value="2107">2107</option><option value="2106">2106</option><option value="2105">2105</option><option value="2104">2104</option><option value="2103">2103</option><option value="2102">2102</option><option value="2101">2101</option><option value="2100">2100</option><option value="2099">2099</option><option value="2098">2098</option><option value="2097">2097</option><option value="2096">2096</option><option value="2095">2095</option><option value="2094">2094</option><option value="2093">2093</option><option value="2092">2092</option><option value="2091">2091</option><option value="2090">2090</option><option value="2089">2089</option><option value="2088">2088</option><option value="2087">2087</option><option value="2086">2086</option><option value="2085">2085</option><option value="2084">2084</option><option value="2083">2083</option><option value="2082">2082</option><option value="2081">2081</option><option value="2080">2080</option><option value="2079">2079</option><option value="2078">2078</option><option value="2077">2077</option><option value="2076">2076</option><option value="2075">2075</option><option value="2074">2074</option><option value="2073">2073</option><option value="2072">2072</option><option value="2071">2071</option><option value="2070">2070</option><option value="2069">2069</option><option value="2068">2068</option><option value="2067">2067</option><option value="2066">2066</option><option value="2065">2065</option><option value="2064">2064</option><option value="2063">2063</option><option value="2062">2062</option><option value="2061">2061</option><option value="2060">2060</option><option value="2059">2059</option><option value="2058">2058</option><option value="2057">2057</option><option value="2056">2056</option><option value="2055">2055</option><option value="2054">2054</option><option value="2053">2053</option><option value="2052">2052</option><option value="2051">2051</option><option value="2050">2050</option><option value="2049">2049</option><option value="2048">2048</option><option value="2047">2047</option><option value="2046">2046</option><option value="2045">2045</option><option value="2044">2044</option><option value="2043">2043</option><option value="2042">2042</option><option value="2041">2041</option><option value="2040">2040</option><option value="2039">2039</option><option value="2038">2038</option><option value="2037">2037</option><option value="2036">2036</option><option value="2035">2035</option><option value="2034">2034</option><option value="2033">2033</option><option value="2032">2032</option><option value="2031">2031</option><option value="2030">2030</option><option value="2029">2029</option><option value="2028">2028</option><option value="2027">2027</option><option value="2026">2026</option><option value="2025">2025</option><option value="2024">2024</option><option value="2023">2023</option><option value="2022">2022</option><option value="2021">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option selected="selected" value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option></select></div></div>
</div>
<pre class=" language-javascript"><code class=" language-javascript"><span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_1 .example_input'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">dayMonthYearCalendar</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    container<span class="token punctuation">:</span> <span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_1 .selects_container'</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> hideInput<span class="token punctuation">:</span> <span class="token keyword">false</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

<p>You can set month names.</p>
<div id="example_2" class="example">
    <input value="22.02.2015" id="dateinput_2" class="example_input">
    <div class="selects_container"><div class="dmy-cal-days">    <select id="dateinput_2Days"><option value="0" disabled="disabled">dd</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option selected="selected" value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option></select></div><div class="dmy-cal-months">  <select id="dateinput_2Months"><option value="0" disabled="disabled">mm</option><option value="1">January</option><option selected="selected" value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></div><div class="dmy-cal-years">  <select id="dateinput_2Years"><option value="0" disabled="disabled">yyyy</option><option value="2116">2116</option><option value="2115">2115</option><option value="2114">2114</option><option value="2113">2113</option><option value="2112">2112</option><option value="2111">2111</option><option value="2110">2110</option><option value="2109">2109</option><option value="2108">2108</option><option value="2107">2107</option><option value="2106">2106</option><option value="2105">2105</option><option value="2104">2104</option><option value="2103">2103</option><option value="2102">2102</option><option value="2101">2101</option><option value="2100">2100</option><option value="2099">2099</option><option value="2098">2098</option><option value="2097">2097</option><option value="2096">2096</option><option value="2095">2095</option><option value="2094">2094</option><option value="2093">2093</option><option value="2092">2092</option><option value="2091">2091</option><option value="2090">2090</option><option value="2089">2089</option><option value="2088">2088</option><option value="2087">2087</option><option value="2086">2086</option><option value="2085">2085</option><option value="2084">2084</option><option value="2083">2083</option><option value="2082">2082</option><option value="2081">2081</option><option value="2080">2080</option><option value="2079">2079</option><option value="2078">2078</option><option value="2077">2077</option><option value="2076">2076</option><option value="2075">2075</option><option value="2074">2074</option><option value="2073">2073</option><option value="2072">2072</option><option value="2071">2071</option><option value="2070">2070</option><option value="2069">2069</option><option value="2068">2068</option><option value="2067">2067</option><option value="2066">2066</option><option value="2065">2065</option><option value="2064">2064</option><option value="2063">2063</option><option value="2062">2062</option><option value="2061">2061</option><option value="2060">2060</option><option value="2059">2059</option><option value="2058">2058</option><option value="2057">2057</option><option value="2056">2056</option><option value="2055">2055</option><option value="2054">2054</option><option value="2053">2053</option><option value="2052">2052</option><option value="2051">2051</option><option value="2050">2050</option><option value="2049">2049</option><option value="2048">2048</option><option value="2047">2047</option><option value="2046">2046</option><option value="2045">2045</option><option value="2044">2044</option><option value="2043">2043</option><option value="2042">2042</option><option value="2041">2041</option><option value="2040">2040</option><option value="2039">2039</option><option value="2038">2038</option><option value="2037">2037</option><option value="2036">2036</option><option value="2035">2035</option><option value="2034">2034</option><option value="2033">2033</option><option value="2032">2032</option><option value="2031">2031</option><option value="2030">2030</option><option value="2029">2029</option><option value="2028">2028</option><option value="2027">2027</option><option value="2026">2026</option><option value="2025">2025</option><option value="2024">2024</option><option value="2023">2023</option><option value="2022">2022</option><option value="2021">2021</option><option value="2020">2020</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option selected="selected" value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option></select></div></div>
</div>
<pre class=" language-javascript"><code class=" language-javascript"><span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_2 .example_input'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">dayMonthYearCalendar</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    container<span class="token punctuation">:</span> <span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_2 .selects_container'</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> hideInput<span class="token punctuation">:</span> <span class="token keyword">false</span>
    <span class="token punctuation">,</span> monthNames<span class="token punctuation">:</span> $<span class="token punctuation">.</span>datepicker<span class="token punctuation">.</span>_defaults<span class="token punctuation">.</span>monthNames
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

<p>You can set minimum and maximum values for date.</p>
<div id="example_3" class="example">
    <input value="22.04.2016" id="dateinput_3" class="example_input">
    <div class="selects_container"><div class="dmy-cal-days">    <select id="dateinput_3Days"><option value="0" disabled="disabled">dd</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option selected="selected" value="22">22</option></select></div><div class="dmy-cal-months">  <select id="dateinput_3Months"><option value="0" disabled="disabled">mm</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option selected="selected" value="4">April</option></select></div><div class="dmy-cal-years">  <select id="dateinput_3Years"><option value="0" disabled="disabled">yyyy</option><option selected="selected" value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option></select></div></div>
</div>
<pre class=" language-javascript"><code class=" language-javascript"><span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_3 .example_input'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">dayMonthYearCalendar</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    container<span class="token punctuation">:</span> <span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_3 .selects_container'</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> hideInput<span class="token punctuation">:</span> <span class="token keyword">false</span>
    <span class="token punctuation">,</span> monthNames<span class="token punctuation">:</span> $<span class="token punctuation">.</span>datepicker<span class="token punctuation">.</span>_defaults<span class="token punctuation">.</span>monthNames
    <span class="token punctuation">,</span> minDate<span class="token punctuation">:</span> <span class="token keyword">new</span> <span class="token class-name">Date</span><span class="token punctuation">(</span><span class="token number">2010</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">15</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> maxDate<span class="token punctuation">:</span> <span class="token keyword">new</span> <span class="token class-name">Date</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

<p>It is possible to change date format.<br>
You must set two functions: convert String to Date and other function 
that convert Date to String. In this example "formatDate" function from <a href="http://jqueryui.com/datepicker/">jQuery UI Datepicker</a> is used to convert Date to String. <a href="http://momentjs.com/">Moment.js</a> is used to convert String to Date.</p>
<div id="example_4" class="example">
    <input value="April 22, 2016" id="dateinput_4" class="example_input">
    <div class="selects_container"><div class="dmy-cal-days">    <select id="dateinput_4Days"><option value="0" disabled="disabled">dd</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option selected="selected" value="22">22</option></select></div><div class="dmy-cal-months">  <select id="dateinput_4Months"><option value="0" disabled="disabled">mm</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option selected="selected" value="4">April</option></select></div><div class="dmy-cal-years">  <select id="dateinput_4Years"><option value="0" disabled="disabled">yyyy</option><option selected="selected" value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option></select></div></div>
</div>
<pre class=" language-javascript"><code class=" language-javascript"><span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_4 .example_input'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">dayMonthYearCalendar</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    container<span class="token punctuation">:</span> <span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_4 .selects_container'</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> hideInput<span class="token punctuation">:</span> <span class="token keyword">false</span>
    <span class="token punctuation">,</span> monthNames<span class="token punctuation">:</span> $<span class="token punctuation">.</span>datepicker<span class="token punctuation">.</span>_defaults<span class="token punctuation">.</span>monthNames
    <span class="token punctuation">,</span> minDate<span class="token punctuation">:</span> <span class="token keyword">new</span> <span class="token class-name">Date</span><span class="token punctuation">(</span><span class="token number">2010</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">15</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> maxDate<span class="token punctuation">:</span> <span class="token keyword">new</span> <span class="token class-name">Date</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">,</span> dateFormatFunction<span class="token punctuation">:</span> <span class="token keyword">function</span><span class="token punctuation">(</span>date<span class="token punctuation">)</span> <span class="token punctuation">{</span>
      <span class="token comment" spellcheck="true">// date -&gt; string
</span>      <span class="token keyword">return</span> $<span class="token punctuation">.</span>datepicker<span class="token punctuation">.</span><span class="token function">formatDate</span><span class="token punctuation">(</span><span class="token string">'MM d, yy'</span><span class="token punctuation">,</span>date<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
    <span class="token punctuation">,</span> dateParseFunction<span class="token punctuation">:</span> <span class="token keyword">function</span><span class="token punctuation">(</span>dateString<span class="token punctuation">)</span> <span class="token punctuation">{</span>
      <span class="token comment" spellcheck="true">// string -&gt; date
</span>      <span class="token keyword">return</span> <span class="token function">moment</span><span class="token punctuation">(</span>dateString<span class="token punctuation">,</span> <span class="token string">'MMM D, YYYY'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">toDate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

<h3>Styles</h3>
<p>Selects have css classes <code class=" language-markup">"dmy-cal-days"</code>, <code class=" language-markup">"dmy-cal-months"</code>, <code class=" language-markup">"dmy-cal-years"</code>. You can specify your class names. There are options: <code class=" language-markup">"daysClass"</code>, <code class=" language-markup">"monthsClass"</code>, <code class=" language-markup">"yearsClass"</code>.</p>

<h3>Events</h3>
<p>You should bind event <code class=" language-markup">"dmy:update"</code> on selects, if  you want to watch for each select changes.</p>
<pre class=" language-javascript"><code class=" language-javascript"><span class="token function">$</span><span class="token punctuation">(</span><span class="token string">'#example_4 .selects_container select'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">bind</span><span class="token punctuation">(</span><span class="token string">'dmy:update'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">{</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

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
        <script type="text/javascript" src="day-month-year-calendar_files/prism.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/day-month-year-calendar.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/datepicker.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/moment.js"></script>
        <script type="text/javascript" src="day-month-year-calendar_files/main.js"></script>
    

</body></html>