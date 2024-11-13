function showUserData(id) {
  let user = getUser(id);

  user.then((data) => {
    let inputID = document.querySelector('input[name="edit_id"]');
    let inputName = document.querySelector('input[name="edit_name"]');
    let inputDeposit = document.querySelector('input[name="edit_deposit"]');
    let inputCreditCard = document.querySelector(
      'input[name="edit_credit_card"]'
    );

    inputID.value = data.id;
    inputName.value = data.name;
    inputDeposit.value = data.deposit;
    inputCreditCard.value = data.credit_card;
  });
}

function fillTable(data) {
  let html = "There is no account.";

  if (data.length > 0) {
    html = ``;

    data.forEach((el) => {
      html += `<tr>
        <td>${el.id}</td>
        <td>${el.name}</td>
        <td>${formatCurrency(el.deposit, "USA", "EUR")}</td>
        <td>${el.credit_card.toUpperCase()}</td>
        <td><button data-toggle="modal" data-target="#editUserModal" onclick="showUserData(${
          el.id
        })" class="btn btn-sm btn-info">Edit</button></td>
        <td><button onclick="deleteUser(${
          el.id
        })" class="btn btn-sm btn-danger">Delete</button></td>
      </tr>`;
    });
  }

  document.querySelector("#main").innerHTML = html;
}

async function loadUsers() {
  let data = await fetch("php/load.php");
  data = await data.json();

  fillTable(data);
}

async function getUser(id) {
  let user = await fetch(`php/get_user.php?id=${id}`);
  user = await user.json();

  return user;
}

async function insertUser(data) {
  let user = await fetch("php/insert_user.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  let res = await user.json();

  if (res === true) {
    loadUsers();

    // clear inputs
    document.querySelector('input[name="name"]').value =
      document.querySelector('input[name="deposit"]').value =
      document.querySelector('input[name="credit_card"]').value =
        "";
  } else alert(res);
}

async function editUser(data) {
  let user = await fetch("php/edit_user.php", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  let res = await user.json();

  if (res > 0) {
    document.querySelector("#closeModalBtn").click();
    loadUsers();
  } else alert(res);
}

async function deleteUser(id) {
  if (!confirm("Da li ste sigurni da zelite da obrisete profil?")) return;

  let user = await fetch(`php/delete_user.php?id=${id}`, { method: "DELETE" });
  let res = await user.json();

  res ? loadUsers() : alert(res);
}

// Format Currency
const formatCurrency = (value, locale, cur) => {
  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency: cur,
  }).format(value);
};

async function loadFilterOptions() {
  let container = document.querySelector("#filterCards");
  let html = "";

  let data = await fetch("php/load.php");
  data = await data.json();

  let cards = data.map((el) => el.credit_card);
  cards = new Set(cards);

  cards.forEach((card) => {
    html += `<li class="list-group-item">${card.toUpperCase()} <input type="checkbox" name="filter_${card}" data-card_type="${card}"/></li>`;
  });

  container.innerHTML = html;
}

async function loadFilteredData(cards) {
  let data = await fetch("php/filter_data.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(cards),
  });
  data = await data.json();

  fillTable(data);
}

async function loadMatchingData(value) {
  let data = await fetch("php/load.php");
  data = await data.json();

  data = data.filter((el) => el.name.toLowerCase().includes(value));

  fillTable(data);
}

async function sortUsers(sorted) {
  let data = await fetch("php/load.php");
  data = await data.json();

  if (!sorted) data = data.sort((a, b) => b.deposit - a.deposit);

  fillTable(data);
}
