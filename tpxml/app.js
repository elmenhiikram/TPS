let xmlData;

fetch(`books.xml?t=${new Date().getTime()}`)
    .then(response => response.text())
    .then(data => {
        const parser = new DOMParser();
        xmlData = parser.parseFromString(data, 'application/xml');
        const books = xmlData.getElementsByTagName('book');
        displayBooks(books);
        modifySecondBook(books);
        addBookBeforeLast(books);

        const addForm = document.forms['add-book'];
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const title = document.querySelector('#book-name').value;
            const author = document.querySelector('#book-author').value;
            const price = document.querySelector('#book-price').value;
            if (title && author && price) {
                addBook(title, author, price);
            } else {
                alert('Veuillez remplir tous les champs');
            }
        });

        const searchForm = document.querySelector('#search-books');
        searchForm.addEventListener('input', filterBooks);
    })
    .catch(error => console.error('Erreur lors du chargement du fichier XML:', error));

function displayBooks(books) {
    const demo = document.querySelector('#demo ul');
    demo.innerHTML = '';
    Array.from(books).forEach((book, index) => {
        const title = book.getElementsByTagName('title')[0].textContent;
        const author = book.getElementsByTagName('author')[0].textContent;
        const priceElement = book.getElementsByTagName('price')[0];
        if (!priceElement.getAttribute('currency')) {
            priceElement.setAttribute('currency', 'dollars');
        }
        const price = parseFloat(priceElement.textContent).toFixed(2);
        const currency = priceElement.getAttribute('currency');

        const li = document.createElement('li');
        const bookTitle = document.createElement('span');
        const bookAuthor = document.createElement('span');
        const bookPrice = document.createElement('span');
        const deleteBtn = document.createElement('button');

        bookTitle.textContent = `Title: ${title}`;
        bookAuthor.textContent = `Author: ${author}`;
        bookPrice.textContent = `Price: ${price} ${currency}`;
        deleteBtn.textContent = 'Delete';
        deleteBtn.classList.add('delete');

        deleteBtn.addEventListener('click', () => deleteBook(index));

        li.appendChild(bookTitle);
        li.appendChild(bookAuthor);
        li.appendChild(bookPrice);
        li.appendChild(deleteBtn);
        demo.appendChild(li);
    });
}

function addBook(title, author, price) {
    const newBook = xmlData.createElement('book');
    const titleElement = xmlData.createElement('title');
    const authorElement = xmlData.createElement('author');
    const priceElement = xmlData.createElement('price');
    titleElement.textContent = title;
    authorElement.textContent = author;
    priceElement.textContent = price;
    priceElement.setAttribute('currency', 'dollars');
    newBook.appendChild(titleElement);
    newBook.appendChild(authorElement);
    newBook.appendChild(priceElement);
    const parentNode = xmlData.getElementsByTagName('books')[0];
    parentNode.appendChild(newBook);
    displayBooks(xmlData.getElementsByTagName('book'));
    document.querySelector('#book-name').value = '';
    document.querySelector('#book-author').value = '';
    document.querySelector('#book-price').value = '';
}

function deleteBook(index) {

    const books = xmlData.getElementsByTagName('book');
    if (index >= 0 && index < books.length) {
        const bookToDelete = books[index];
        bookToDelete.parentNode.removeChild(bookToDelete);
        displayBooks(xmlData.getElementsByTagName('book'));
    }
}

function modifySecondBook(books) {
    if (books.length >= 2) {
        const secondBook = books[1];
        secondBook.getElementsByTagName('title')[0].textContent = 'Updated Book Title';
        secondBook.getElementsByTagName('author')[0].textContent = 'Updated Author';
        secondBook.getElementsByTagName('price')[0].textContent = '35.99';
        displayBooks(books);
    }
}

function addBookBeforeLast(books) {
    if (!xmlData) {
        console.error("Le fichier XML n'a pas été chargé.");
        return;
    }

    const newBook = xmlData.createElement('book');
    const titleElement = xmlData.createElement('title');
    const authorElement = xmlData.createElement('author');
    const priceElement = xmlData.createElement('price');

    titleElement.textContent = 'New Book Before Last';
    authorElement.textContent = 'New Author';
    priceElement.textContent = '40.00';
    priceElement.setAttribute('currency', 'dollars');

    newBook.appendChild(titleElement);
    newBook.appendChild(authorElement);
    newBook.appendChild(priceElement);

    const parentNode = books[0].parentNode;
    if (books.length > 0) {
        parentNode.insertBefore(newBook, books[books.length - 1]);
    } else {
        parentNode.appendChild(newBook);
    }

    displayBooks(xmlData.getElementsByTagName('book'));
}

function filterBooks() {
    const searchTerm = document.querySelector('#search-books input').value.toLowerCase();
    const books = xmlData.getElementsByTagName('book');
    const filteredBooks = Array.from(books).filter((book) => {
        const title = book.getElementsByTagName('title')[0].textContent.toLowerCase();
        return title.includes(searchTerm);
    });

    displayBooks(filteredBooks);
}

