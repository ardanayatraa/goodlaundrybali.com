const puppeteer = require('puppeteer');
const fs = require('fs');

(async () => {
    const url = process.argv[2]; // URL passed as the first argument
    const outputPath = process.argv[3]; // Output path passed as the second argument

    if (!url || !outputPath) {
        console.error('Usage: node generateImage.js <url> <outputPath>');
        process.exit(1);
    }

    try {
        console.log(`Starting Puppeteer to capture screenshot from: ${url}`);
        console.log(`Output path: ${outputPath}`);

        const browser = await puppeteer.launch({ headless: true });
        const page = await browser.newPage();

        // Enable verbose logging
        page.on('console', msg => console.log('PAGE LOG:', msg.text()));

        // Set viewport size
        await page.setViewport({ width: 1280, height: 720 });

        // Navigate to the URL
        await page.goto(url, { waitUntil: 'networkidle0' });

        // Take a screenshot and save it to the specified path
        await page.screenshot({ path: outputPath });

        // Verify if the file was saved
        if (fs.existsSync(outputPath)) {
            console.log(`Image successfully saved to ${outputPath}`);
        } else {
            console.error(`Failed to save image to ${outputPath}`);
        }

        await browser.close();
    } catch (error) {
        console.error('Error generating image:', error);
        process.exit(1);
    }
})();
