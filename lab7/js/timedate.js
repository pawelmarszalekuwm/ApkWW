var timerID = null;
var timerRunning = false;
var oscarDate = new Date('March 10, 2025 00:00:00').getTime(); 

function stopClock() {
    if (timerRunning) {
        clearTimeout(timerID);
        timerRunning = false;
    }
}

function startClock() {
    stopClock();
    showTimeRemaining();
}

function showTimeRemaining() {
    var now = new Date().getTime();
    var timeDifference = oscarDate - now;

    var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

    var countdown = "Do gali pozostało "+days + " days, " + 
                    ((hours < 10) ? "0" + hours : hours) + " hours, " +
                    ((minutes < 10) ? "0" + minutes : minutes) + " minutes, " + 
                    ((seconds < 10) ? "0" + seconds : seconds) + " seconds ";

    document.getElementById("zegarek").innerHTML = countdown;

    if (timeDifference > 0) {
        timerID = setTimeout(showTimeRemaining, 1000); 
        timerRunning = true;
    } else {
        document.getElementById("zegarek").innerHTML = "The Oscars are happening now!";
        stopClock();
    }
}
