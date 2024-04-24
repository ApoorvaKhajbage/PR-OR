function generateFibonacci() {
    const numTermsInput = document.getElementById('numTerms');
    const numTerms = parseInt(numTermsInput.value);

    if (!isNaN(numTerms) && numTerms > 0) {
        let fibonacciSeries = 'Fibonacci Series: ';

        let firstTerm = 0, secondTerm = 1;
        for (let i = 0; i < numTerms; i++) {
            fibonacciSeries += firstTerm + ' ';

            let nextTerm = firstTerm + secondTerm;
            firstTerm = secondTerm;
            secondTerm = nextTerm;
        }

        const fibonacciSeriesOutput = document.getElementById('fibonacciSeries');
        fibonacciSeriesOutput.textContent = fibonacciSeries;
    } else {
        alert('Please enter a valid number of terms (greater than 0).');
    }
}
