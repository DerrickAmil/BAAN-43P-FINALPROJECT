<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>

    <div id="content">
			<div style="position: relative">
  				<div style="top: 10; right: 20; width: 100px; text-align:right;">
				<form>
				    <input type="button" value="BACK" onclick="history.back()" >
				</form>
				</div>
			</div>
		</div>
        
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="weather.css">
</head>
<body>
    <div class="container">
        <div class="current-info">

            <div class="date-container">

                <div class="time" id="time">
                    12:14 <span id="am-pm"> PM </span>
                </div>
                <div class="date" id="date">
                    Monday, 24 May
                </div>

                <div class="others" id="current-weather-items">
                    <div class="weather-item">
                        <div>Pressure</div>
                        <div>-</div>
                    </div>
                    <div class="weather-item">
                        <div>Wind</div>
                        <div>-</div>
                    </div>
                    <div class="weather-item">
                        <div>Humidity</div>
                        <div>-</div>
                    </div>
                </div>
            </div>

            <div class="place-container">
                <input type="search" id="city" placeholder="Place">
                <div class="time-zone" id="time-zone">Continent/Time-Zone</div>
                <div class="country" id="country">Country</div>
            </div>
        </div>
    </div>
    <div class="future-forecast">
        <div class="today" id="current-temp">
            <div class="other">
                <div class="day">Today</div>
                <div class="temp">High Temp - &#176; C</div>
                <div class="temp">Low Temp -  &#176; C</div>
            </div>
        </div>
        <div class="today" id="day2">
            <div class="other">
                <div class="day">Day 2</div>
                <div class="temp">High Temp -  &#176; C</div>
                <div class="temp">Low Temp -  &#176; C</div>
            </div>
        </div>
        <div class="today" id="day3">
            <div class="other">
                <div class="day">Day 3</div>
                <div class="temp">High Temp - &#176; C</div>
                <div class="temp">Low Temp -  &#176; C</div>
            </div>
        </div>


        <!--<div class="weather-forecast" id="weather-forecast">
            <div class="weather-forecast-item">
                <div class="day">Mon</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
            <div class="weather-forecast-item">
                <div class="day">Tue</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
            <div class="weather-forecast-item">
                <div class="day">Wed</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
            <div class="weather-forecast-item">
                <div class="day">Thu</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
            <div class="weather-forecast-item">
                <div class="day">Fri</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
            <div class="weather-forecast-item">
                <div class="day">Sat</div>
                <img src="http://openweathermap.org/img/wn/10d@2x.png" alt="weather-icon" class="w-icon">
                <div class="temp">Day - 25.6 &#176; C</div>
                <div class="temp">Night - 25.6 &#176; C</div>
            </div>
        </div>-->
    </div>
    <script src="weather.js"></script>
</body>
</html>
