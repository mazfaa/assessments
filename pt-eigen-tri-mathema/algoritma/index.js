// ALGORITMA

// Soal No. 1

function reverseString(input) {
  let letters = input.replace(/[0-9]/g, "");
  let numbers = input.replace(/\D/g, "");

  let reversedLetters = letters.split("").reverse().join("");

  return reversedLetters + numbers;
}

let result = reverseString("NEGIE1");
console.log(result);

// Soal No. 2

function longest(sentence) {
  let words = sentence.split(" ");

  let longestWord = "";
  for (let word of words) {
    if (word.length > longestWord.length) {
      longestWord = word;
    }
  }

  return `${longestWord}: ${longestWord.length} character`;
}

const sentence = "Saya sangat senang mengerjakan soal algoritma";
console.log(longest(sentence));

// Soal No. 3
function countOccurrences(input, query) {
  let result = [];

  for (let q of query) {
    let count = input.filter((word) => word === q).length;
    result.push(count);
  }

  return result;
}

const INPUT = ["xc", "dz", "bbb", "dz"];
const QUERY = ["bbb", "ac", "dz"];

console.log(countOccurrences(INPUT, QUERY));

// Soal No. 4
function diagonalDifference(matrix) {
  let n = matrix.length;
  let diagonal1 = 0;
  let diagonal2 = 0;

  for (let i = 0; i < n; i++) {
    diagonal1 += matrix[i][i];
    diagonal2 += matrix[i][n - 1 - i];
  }

  return Math.abs(diagonal1 - diagonal2);
}

const matrix = [
  [1, 2, 0],
  [4, 5, 6],
  [7, 8, 9],
];

console.log(diagonalDifference(matrix));
