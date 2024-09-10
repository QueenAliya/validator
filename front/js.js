const firstMenu = document.querySelector('.site-perfomance-block-open');
const firstHidden = document.querySelectorAll('.site-perfomance-block-info-line > .site-perfomance-block-info-line-block-hidden');
const secondMenu = document.querySelector('#performance-info-block-indicators-title-block-open');
const secondHidden = document.querySelectorAll('.performance-info-block-indicators-item-block-text-hidden');
const OpenAudits = document.querySelector('#successful-audits-open');
const hiddenAudits = document.querySelector('.successful-audits-hidden-tabs')
const OpenAuditsSecond = document.querySelector('#successful-audits-open-second');
const hiddenAuditsSecond = document.querySelector('.successful-audits-hidden-tabs-second')
const OpenAuditsThird = document.querySelector('#successful-audits-open-third');
const hiddenAuditsThird = document.querySelector('.successful-audits-hidden-tabs-third')
const OpenAuditsFour = document.querySelector('#successful-audits-open-four');
const hiddenAuditsFour = document.querySelector('.successful-audits-hidden-tabs-four')

firstMenu.addEventListener("click", function() {
  this.classList.add("active");
  if(this.classList.contains('active')) {
    firstHidden.forEach(firstHidden => {
      firstHidden.classList.toggle('active');
    });
    firstMenu.innerText = (firstMenu.innerText == 'Развернуть') ? firstMenu.innerText = 'Скрыть' : firstMenu.innerText = 'Развернуть';
  }
});
secondMenu.addEventListener('click', function() {
  this.classList.add("active");
  if(this.classList.contains('active')) {
    secondHidden.forEach(secondHidden => {
      secondHidden.classList.toggle('active');
    });
    secondMenu.innerText =(secondMenu.innerText == 'Развернуть') ? secondMenu.innerText = 'Скрыть' : secondMenu.innerText = 'Развернуть';
  }
})

OpenAudits.addEventListener('click', function() {
  this.classList.add('active');
  if(this.classList.contains('active')) {
    hiddenAudits.classList.toggle('active');
  }
  this.innerText =(this.innerText == 'Показать') ? this.innerText = 'Скрыть' : this.innerText = 'Показать';

})

OpenAuditsSecond.addEventListener('click', function() {
  this.classList.add('active');
  if(this.classList.contains('active')) {
    hiddenAuditsSecond.classList.toggle('active');
  }
  this.innerText =(this.innerText == 'Показать') ? this.innerText = 'Скрыть' : this.innerText = 'Показать';

})

OpenAuditsThird.addEventListener('click', function() {
  this.classList.add('active');
  if(this.classList.contains('active')) {
    hiddenAuditsThird.classList.toggle('active');
  }
  this.innerText =(this.innerText == 'Показать') ? this.innerText = 'Скрыть' : this.innerText = 'Показать';

})

OpenAuditsFour.addEventListener('click', function() {
  this.classList.add('active');
  if(this.classList.contains('active')) {
    hiddenAuditsFour.classList.toggle('active');
  }
  this.innerText =(this.innerText == 'Показать') ? this.innerText = 'Скрыть' : this.innerText = 'Показать';

})

jQuery(document).ready(function () {
  //Менюшка с данными
  $('.performance-info-block-tabs-open').on('click', function () {
    var parents = $(this).closest('.parameter-wrap--js');
    parents.children('.parameter-block--js').slideToggle();
    parents.toggleClass('active');
});
//Развернуть 1
$(".tabs-item--js").on('click', function () {
  var itemThumbs = $(this).attr('data-thumb'),
    blockThumbs = $(".tabs-block--js[data-thumb= '" + itemThumbs + "']");
  $(this).addClass('active').siblings().removeClass('active');
  blockThumbs.addClass('active').siblings().removeClass('active');
});
//Развернуть 2
$(".performance-info-block-tabs--js").on('click', function () {
  var itemThumbs = $(this).attr('data-thumb'),
    blockThumbs = $(".performance-info-block--js[data-thumb= '" + itemThumbs + "']");
  $(this).addClass('active').siblings().removeClass('active');
  blockThumbs.addClass('active').siblings().removeClass('active');
});
 //Текст при наведении на свг
$('.performance-info-block-top-left-svg').mouseover(function () {
  $(this).find('.performance-info-block-top-left-svg-text').css('display', 'block')
});
$('.performance-info-block-top-left-svg').mouseout(function () {
  $(this).find('.performance-info-block-top-left-svg-text').css('display', 'none')
});
})