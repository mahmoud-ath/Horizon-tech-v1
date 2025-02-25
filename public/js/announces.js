

const articlesContainer = document.getElementById('articles');

articles.forEach(article => {
   const articleElement = document.createElement('div');
   articleElement.classList.add('article');



articlesContainer.appendChild(articleElement);
});
