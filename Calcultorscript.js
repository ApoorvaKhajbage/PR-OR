document.addEventListener('DOMContentLoaded', function() {
    const display = document.getElementById('display');

    // Function to handle button clicks
    function handleClick(event) {
        const buttonValue = event.target.value;
        if (buttonValue === '=') {
            try {
                display.value = eval(display.value);
            } catch (error) {
                display.value = 'Error';
            }
        } else if (buttonValue === 'AC') {
            display.value = '';
        } else if (buttonValue === 'DE') {
            display.value = display.value.toString().slice(0, -1);
        } else {
            display.value += buttonValue;
        }
    }

    // Add event listeners to all buttons
    const buttons = document.querySelectorAll('input[type="button"]');
    buttons.forEach(button => {
        button.addEventListener('click', handleClick);
    });
});
