// buttons
let addAccount = document.querySelector("#addBtn");
let saveAccount = document.querySelector("#saveBtn");
let editAccount = document.querySelector('input[name="save_edit"]');
let toggleFilter = document.querySelector("#toggleFilter");
let applyFilter = document.querySelector("#applyFilter");
let searchInput = document.querySelector("#searchInput");
let sortBtn = document.querySelector("#sortBtn");

loadUsers();
loadFilterOptions();

// events
addAccount.onclick = (e) => {
  e.preventDefault();
  document.querySelector("#addView").classList.toggle("hide");
};

saveAccount.onclick = (e) => {
  let data = {
    name: document.querySelector('input[name="name"]').value,
    deposit: document.querySelector('input[name="deposit"]').value,
    credit_card: document.querySelector('input[name="credit_card"]').value,
  };

  insertUser(data);
};

editAccount.onclick = (e) => {
  e.preventDefault();

  let data = {
    id: document.querySelector('input[name="edit_id"]').value,
    name: document.querySelector('input[name="edit_name"]').value,
    deposit: document.querySelector('input[name="edit_deposit"]').value,
    credit_card: document.querySelector('input[name="edit_credit_card"]').value,
  };

  editUser(data);
};

toggleFilter.onclick = () => {
  document.querySelector("#filters").classList.toggle("hide");
};

applyFilter.onclick = (e) => {
  e.preventDefault();
  let filters = document.querySelectorAll('input[name*="filter_"]');
  let cards = [];

  filters.forEach((el) => {
    if (el.checked) {
      cards.push(el.getAttribute("data-card_type"));
    }
  });

  if (cards.length > 0) loadFilteredData(cards);
};

searchInput.oninput = (e) => {
  e.preventDefault();
  let val = e.target.value;

  loadMatchingData(val);
};

let sorted = false;
sortBtn.onclick = () => {
  sortUsers(sorted);
  sorted = !sorted;
};
