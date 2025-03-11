const fs = require('fs');
const font = fs.readFileSync('THSarabunNew.ttf');
const base64Font = font.toString('base64');
console.log(base64Font);
fs.writeFileSync('thSarabunNewBase64.txt', base64Font);