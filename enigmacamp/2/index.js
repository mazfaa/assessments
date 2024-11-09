// const arr = [7, 6, 4, 10, 7, 3];

// const counter = {};

// for (let i = 0; i < arr.length; i++) {
//   if (counter[arr[i]] === undefined) {
//     counter[arr[i]] = 1;
//   } else {
//     counter[arr[i]] = counter[i] + 1;
//   }
// }

// const voter = [];

// for (const i in counter) {
//   if (voter.length == 0) {
//     voter[0] = i;
//     voter[1] = counter[i];
//   } else if (voter[1] < counter[i]) {
//     voter[0] = i;
//     voter[1] = counter[i];
//   }
// }

// // console.log(
// //   "Jadi angka yang paling banyak muncul adalah angka " + Number(voter[0])
// // );

// console.log(counter);
// console.log(voter);

// const arr = [4, 5, 1, 3, 6];

// let num = 4;

// const passedNums = [];

// for (const i of arr) {
//   if (i >= num) {
//     passedNums.push(i);
//   }
// }

// console.log(
//   `Daftar angka yang lebih dari atau sama dengan angka ${num} adalah ${passedNums}`
// );

// const arr = [3, 5, 7, 8, 6];
// arr.sort((a, b) => a - b);

// const tracker = [];

// for (let i = 0; i < arr.length; i++) {
//   if (arr[i + 1] - arr[i] === 2) {
//     console.log(`Angka yang hilang adalah angka ${arr[i] + 1}`);
//     return;
//   }
// }
