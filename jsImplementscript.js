document.addEventListener('DOMContentLoaded', function() {
    // Task 2: Display an alert when the webpage loads
    alert('Welcome to JavaScript Tasks!');

    // Task 3: Add event listener to alert button
    const alertButton = document.getElementById('alertButton');
    alertButton.addEventListener('click', function() {
        alert('Button clicked! You triggered an alert.');
    });

    // Task 4: Calculate average number of weeks in human lifetime
    const calculateButton = document.getElementById('calculateButton');
    calculateButton.addEventListener('click', function() {
        const ageInput = document.getElementById('ageInput');
        const age = parseInt(ageInput.value);
        if (!isNaN(age) && age >= 0) {
            const averageLifespan = 72; // Average human lifespan in years
            const weeksInYear = 52;
            const totalWeeks = age * weeksInYear;
            const remainingWeeks = (averageLifespan - age) * weeksInYear;
            const message = `You have lived approximately ${totalWeeks} weeks. On average, you have ${remainingWeeks} weeks remaining in your lifetime.`;
            const weeksMessage = document.getElementById('weeksMessage');
            weeksMessage.textContent = message;
        } else {
            alert('Please enter a valid age.');
        }
    });

    // Task 6: Determine time of the day
    const timeOfDayMessage = document.getElementById('timeOfDayMessage');
    const currentHour = new Date().getHours();
    let timeOfDay;
    if (currentHour >= 5 && currentHour < 12) {
        timeOfDay = 'morning';
    } else if (currentHour >= 12 && currentHour < 18) {
        timeOfDay = 'afternoon';
    } else {
        timeOfDay = 'night';
    }
    timeOfDayMessage.textContent = `It's currently ${timeOfDay}.`;
});
