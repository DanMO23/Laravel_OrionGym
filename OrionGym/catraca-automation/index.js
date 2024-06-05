const puppeteer = require('puppeteer');

const fs = require('fs');
const path = require('path');
(async () => {
    const browser = 
    defina o browser firefox
   

    const page = await browser.newPage();

    // Navegar até a página de login
    await page.goto('http://192.168.1.125/#/login');

    // Inserir o usuário e a senha
    await page.type('input[name="username"]', 'ADMIN');
    await page.type('input[name="password"]', 'C@traca');

    // Clicar no botão de login
    await page.click('button[type="submit"]');

    // Esperar a navegação completar
    await page.waitForNavigation();

    // Navegar até a página de registros
    await page.goto('http://192.168.1.125/#/topdata/registros');

    // Esperar que a página de registros carregue
    await page.waitForSelector('#elemento_que_indica_que_a_pagina_carregou'); // Ajuste este seletor conforme necessário

    const screenshotDir = path.resolve(__dirname, 'screenshots');
    if (!fs.existsSync(screenshotDir)) {
        fs.mkdirSync(screenshotDir);
    }

    // Fazer o screenshot e salvar na pasta
    const screenshotPath = path.join(screenshotDir, 'registros.png');
    await page.screenshot({ path: screenshotPath });
    
    // Fechar o navegador
    await browser.close();
})();
