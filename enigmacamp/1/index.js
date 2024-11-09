const nums = [1, 3, 100, 4, 100, 2, 5, 7];

const counter = {};

for (const i of nums) {
  if (counter[i] == undefined) {
    counter[i] = 1;
  } else {
    counter[i]++;
  }
}

// console.log(counter);

const largest = [0, 0];

for (const key in counter) {
  if (counter[key] > largest[1]) {
    largest[0] = key;
    largest[1] = counter[key];
  }
}

const modus = parseInt(largest[0]);

console.log(modus);
