module.exports = async (page, scenario, vp) => {
    console.log('SCENARIO > ' + scenario.label);
    await page.evaluate(() => {
        [...document.getElementsByClassName('lazyload')].forEach(function(img){ window.lazySizes.loader.unveil(img); });
        [...document.getElementsByClassName('js-animation')].forEach(function(element){ element.classList.add("is-appearing"); });
    });

    const stylesPath = require.resolve('./stylesVisualRegression.css');
    await page.addStyleTag({path: stylesPath});

    await require('./clickAndHoverHelper')(page, scenario);
    // add more ready handlers here...
};
