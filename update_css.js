const fs = require('fs');
const file = 'style.css';
let css = fs.readFileSync(file, 'utf8');
let lines = css.split('\n');

// The lines we want to remove are 1635 to 2007 (1-indexed).
// So array indices 1634 to 2006. That's 2006 - 1634 + 1 = 373 elements.
lines.splice(1634, 373);

fs.writeFileSync(file, lines.join('\n'));
console.log('Removed old Thank You page CSS rules. Remaining lines:', lines.length);
