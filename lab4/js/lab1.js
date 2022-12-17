var manualstate = 0;
var countDownDateTime = 0;
var startBtnstate = 0;
var countdownMilliSeconds;
var x, now, days, hours, minutes, seconds, milliseconds;

$(document).ready(function () {
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', 'sound/quietalarm.mp3');

    now = new Date();
    var month = now.getMonth() + 1;
    var day = now.getDate();
    var output = now.getFullYear() + '-' +
            (month < 10 ? '0' : '') + month + '-' +
            (day < 10 ? '0' : '') + day;
    seconds = now.getSeconds();
    minutes = now.getMinutes();
    var time = now.getHours() + ":" +
            (minutes == 0 ? 00 : '') + (minutes < 10 ? 0 : '') + minutes + ":" +
            (seconds == 0 ? 00 : '') + (seconds < 10 ? 0 : '') + seconds;
    $("#EventDate").val(output);
    $("#EventTime").val(time);

    $("#setEventDate").click(function () {
        var countDownDate = $("#EventDate").val();
        var countDownTime = $("#EventTime").val();

        countDownDateTime = new Date(countDownDate + " " + countDownTime);

        var now = new Date();
        var difference = (countDownDateTime - now);
        if (difference < 0) {
            alert("The date or time you have selected has passed, Please select a new date and time.")
        } else {
            alert("Alarm has been set to " + countDownDateTime);
            alert("There's no going back now! MWAHAHA!");
            $("#Days").val(Math.floor(difference / (1000 * 60 * 60 * 24)));
            $("#Hours").val(Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
            $("#Minutes").val(Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60)));
            $("#Seconds").val(Math.floor((difference % (1000 * 60)) / 1000));
            $("#MilliSeconds").val(difference % 1000);
        }
    })


    $("#Start").click(function () {
        if (startBtnstate == 0) {
            startBtnstate = startBtnstate + 1;
            $("#Start").html("Pause");
            if (manualstate == 1) {
                countdownMilliSeconds = $("#Days").val() * (1000 * 60 * 60 * 24) +
                        $("#Hours").val() * (1000 * 60 * 60) +
                        $("#Minutes").val() * (1000 * 60) +
                        $("#Seconds").val() * 1000;
                manualstate = 0;
            } else {
                var now = new Date();
                countdownMilliSeconds = (countDownDateTime - now);
            }
            if (countdownMilliSeconds <= 0) {
                $("#Start").html("Start");
                startBtnstate = 0;
                return;
            }
            x = setInterval(function () {
                countdownMilliSeconds -= 10;
                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(countdownMilliSeconds / (1000 * 60 * 60 * 24));
                var hours = Math.floor((countdownMilliSeconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((countdownMilliSeconds % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((countdownMilliSeconds % (1000 * 60)) / 1000);
                var milliseconds = countdownMilliSeconds % (1000);

                $("#Days").val(days);
                $("#Hours").val(hours);
                $("#Minutes").val(minutes);
                $("#Seconds").val(seconds);
                $("#MilliSeconds").val(milliseconds);
                if (countdownMilliSeconds < 0) {
                    $("#Days").val(0);
                    $("#Hours").val(0);
                    $("#Minutes").val(0);
                    $("#Seconds").val(0);
                    $("#MilliSeconds").val(0);
                    clearInterval(x);
                    $("#Start").html("Quiet");
                    audioElement.play();
                    startBtnstate = 3;
                    return;
                }
            }, 10);
        } else if (startBtnstate == 1) { // Pause
            startBtnstate = 2;
            clearInterval(x);
            $("#Start").html("Resume");
        } else if (startBtnstate == 2) {
            startBtnstate = 1;
            $("#Start").html("Pause");
            x = setInterval(function () {
                countdownMilliSeconds -= 10;

                var days = Math.floor(countdownMilliSeconds / (1000 * 60 * 60 * 24));
                var hours = Math.floor((countdownMilliSeconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((countdownMilliSeconds % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((countdownMilliSeconds % (1000 * 60)) / 1000);
                var milliseconds = countdownMilliSeconds % (1000);

                $("#Days").val(days);
                $("#Hours").val(hours);
                $("#Minutes").val(minutes);
                $("#Seconds").val(seconds);
                $("#MilliSeconds").val(milliseconds);
                // Countdown over, report and ring
                if (countdownMilliSeconds < 0) {
                    $("#Days").val(0);
                    $("#Hours").val(0);
                    $("#Minutes").val(0);
                    $("#Seconds").val(0);
                    $("#MilliSeconds").val(0);
                    clearInterval(x);
                    $("#Start").html("Reset");
                    audioElement.play();
                    startBtnstate = 3;
                    return;
                }
            }, 10);
        } else if (startBtnstate == 3) {
            audioElement.pause();
            startBtnstate = 0;
            clearInterval(x);
            location.reload();
            $("#Start").html("Start");
        }
    })
    $("#Snooze").click(function () {
        audioElement.pause();
        countdownMilliSeconds = 10000;
        $("#Days").val(0);
        $("#Hours").val(0);
        $("#Minutes").val(0);
        $("#Seconds").val(10);
        $("#MilliSeconds").val(0);
        x = setInterval(function () {
            countdownMilliSeconds -= 10;
            days = Math.floor(countdownMilliSeconds / (1000 * 60 * 60 * 24));
            hours = Math.floor((countdownMilliSeconds % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes = Math.floor((countdownMilliSeconds % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((countdownMilliSeconds % (1000 * 60)) / 1000);
            milliseconds = countdownMilliSeconds % (1000);
            $("#Days").val(days);
            $("#Hours").val(hours);
            $("#Minutes").val(minutes);
            $("#Seconds").val(seconds);
            $("#MilliSeconds").val(milliseconds);
            if (countdownMilliSeconds < 0) {
                $("#Days").val(0);
                $("#Hours").val(0);
                $("#Minutes").val(0);
                $("#Seconds").val(0);
                $("#MilliSeconds").val(0);
                clearInterval(x);
                $("#Start").html("Cancel");
                audioElement.play();
                startBtnstate = 3;
                return;
            }
        }, 10);
    })
    $("#Reset").click(function () {
        location.reload();
    })

})