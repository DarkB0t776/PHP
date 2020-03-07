const deleteButtons = document.querySelectorAll('.show-items__delete');
const backdrop = document.querySelector('.backdrop');
const modal = document.querySelector('.modal');
const modalButtonNo = document.querySelector('.modal-button__no');
const modalButtonYes = document.querySelector('.modal-button__yes');

const showBackdrop = () => {
  backdrop.classList.add('backdrop--active');
};
const hideBackdrop = () => {
  backdrop.classList.remove('backdrop--active');
};

const showModal = () => {
  modal.classList.add('modal--active');
};
const hideModal = () => {
  modal.classList.remove('modal--active');
};

const modalHandler = href => {
  showBackdrop();
  showModal();

  modalButtonNo.addEventListener('click', () => {
    hideModal();
    hideBackdrop();
  });

  modalButtonYes.addEventListener('click', event => {
    event.target.href = href;
    hideModal();
    hideBackdrop();
  });
};

for (const btn of deleteButtons) {
  btn.addEventListener('click', event => {
    event.preventDefault();
    const href = event.target.href;
    modalHandler(href);
  });
}

backdrop.addEventListener('click', () => {
  hideModal();
  hideBackdrop();
});
