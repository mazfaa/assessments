const a = [203, 204, 205, 206, 207, 208, 203, 204, 205, 206];
const b = [203, 204, 204, 205, 206, 207, 205, 208, 203, 206, 205, 206, 204];

const missings = [];

for (let i = 0; i < a.length; i++) {
  for (let j = 0; j < b.length; j++) {
    if (a[i] == b[j]) {
      i++;
      continue;
    } else if (missings.length == 0) {
      missings.push(b[j]);
    } else {
      let founded = false;

      for (const k of missings) {
        if (k == b[j]) {
          founded = true;
        }
      }

      if (!founded) {
        missings.push(b[j]);
      }

      if (j - i == 2) {
        i++;
      }
    }
  }
}

console.log(missings);
