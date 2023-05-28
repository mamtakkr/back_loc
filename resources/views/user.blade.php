<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<body>

    <p id="demo"></p>
    
    <script>
        $(document).ready(function() {
            var x = document.getElementById("demo");
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }


            function showPosition(position) {
                console.log(position);
                    x.innerHTML = 'Latitude: ' + position.coords.latitude +
                    '<br>Longitude: ' + position.coords.longitude + '<br><iframe src=https://www.google.com/maps?q=' + position.coords.latitude +',' + position.coords.longitude+'&hl=es;z=14&output=embed width="100%" height="450vh"></iframe>';

                var dataString = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    _token: "{{csrf_token()}}"
                };
                $.ajax({
                    type: "POST",
                    url: "{{route('location-send')}}",
                    data: dataString,
                    success: function(response) {
                        alert(JSON.stringify(response));
                    }
                });
            }


            function showError(error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        x.innerHTML = "User denied the request for Geolocation."
                        break;
                    case error.POSITION_UNAVAILABLE:
                        x.innerHTML = "Location information is unavailable."
                        break;
                    case error.TIMEOUT:
                        x.innerHTML = "The request to get user location timed out."
                        break;
                    case error.UNKNOWN_ERROR:
                        x.innerHTML = "An unknown error occurred."
                        break;
                }
            }

        });
    </script>

</body>

</html>