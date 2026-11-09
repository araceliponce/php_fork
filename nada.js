const library = [
  {
    title: 'Your Next Five Moves: Master the Art of Business Strategy',
    author: 'Patrick Bet-David and Greg Dinkin',
    about: 'A book on how to plan ahead',
    pages: 320,
  },
  {
    title: 'Atomic Habits',
    author: 'James Clear',
    about: 'A practical book about discarding bad habits and building good ones',
    pages: 320,
  },
  {
    title: 'Choose Your Enemies Wisely: Business Planning for the Audacious Few',
    author: 'Patrick Bet-David',
    about:
      "A book that emphasizes the importance of identifying and understanding one's adversaries to succeed in the business world",
    pages: 304,
  },
  {
    title: 'The Embedded Entrepreneur',
    author: 'Arvid Kahl',
    about: 'A book focusing on how to build an audience-driven business',
    pages: 308,
  },
  {
    title: 'How to Be a Coffee Bean: 111 Life-Changing Ways to Create Positive Change',
    author: 'Jon Gordon',
    about: 'A book about effective ways to lead a coffee bean lifestyle',
    pages: 256,
  },
  {
    title: 'The Creative Mindset: Mastering the Six Skills That Empower Innovation',
    author: 'Jeff DeGraff and Staney DeGraff',
    about: 'A book on how to develop creativity and  innovation skills',
    pages: 168,
  },
  {
    title: 'Rich Dad Poor Dad',
    author: 'Robert Kiyosaki and Sharon Lechter',
    about: 'A book about financial literacy, financial independence, and building wealth. ',
    pages: 336,
  },
  {
    title: 'Zero to Sold',
    author: 'Arvid Kahl',
    about: 'A book on how to bootstrap a business',
    pages: 500,
  },
];

console.log("Books in the Library:\n");

function getBookInformation(catalog) {
  return catalog.map(book => `${book.title} by ${book.author}`).join("\n");
}

console.log(getBookInformation(library));

console.log("\nList of book summaries:\n");

function getBookSummaries(catalog) {
  return catalog.map((book) => book.about).join("\n");
}

console.log(getBookSummaries(library));

console.log("\nList of books by Arvid Kahl:\n");

function getBooksByAuthor(catalog, author) {
  return catalog.filter((book) => book.author === author);
}

console.log(getBooksByAuthor(library, "Arvid Kahl"));

console.log("\nList of books by James Clear:\n");
console.log(getBooksByAuthor(library, "James Clear"));

console.log("\nTotal number of pages for all library books:\n");

//al acumulador le sumas las pages de cada item
function getTotalPages(array) {
  return array.reduce((acc, curr) => acc + curr.pages, 0);
}

console.log(getTotalPages(library))







let books = [
  {
    title: 'aaaaa',
    authorName: '',
    releaseYear: 1998
  },
  {
    title: 'bbb',
    authorName: '',
    releaseYear: 1995
  },
  {
    title: 'ccc',
    authorName: '',
    releaseYear: 1991
  }
]




// You should filter out books written after a certain year such as 1950 from the books array and save the filtered array in a new array named filteredBooks.

// You should sort the books in the filteredBooks array according to their releaseYear in ascending order. You learned in a prior lesson that the sort() method will sort the array in place. This means the filteredBooks array will be mutated.

let filteredBooks = books.filter(book => book.releaseYear > 1950)



// should return -1 if the releaseYear of the first book is smaller than that of the second book.
// The sortByYear function should return 1 if the releaseYear of the first book is bigger than that of the second book.
// The sortByYear function should return 0 if both releaseYear values are equal.
function sortByYear(book1, book2) {

}