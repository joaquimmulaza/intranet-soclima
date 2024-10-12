$('.like').on('click', function(event) {
  event.preventDefault();
  postId = event.target.parentNode.parentNode.dataset['postid'];

  var isLike = event.target.previousElementSibling == null;

  $.ajax({
    method: 'POST',
    url: urlLike,
    data: {
      isLike: isLike,
      postId: postId,
      _token: token
    }
  })  .done(function() {
    event.target.innerText = isLike ? event.target.innerText == 'Gostar' ? 'Eu gostei muito!!' : 'Gostar' : event.target.innerText == 'Não gostar' ? 'Eu não gostei!!' : 'Não gostar';


    if (isLike) {
      event.target.nextElementSibling.innerText = 'Não gostar';
    } else {
      event.target.previousElementSibling.innerText = 'Gostar';
    }
  });
});

