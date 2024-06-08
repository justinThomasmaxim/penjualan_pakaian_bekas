// let sideBarItem = document.querySelector(".sidebar");
// let items = document.querySelectorAll(".item");

// sideBarItem.addEventListener("click", function (e) {
//   // console.info(e);
//   if (e.target.className == "item") {
//     console.info("item");

//     items.forEach(function (item) {
//       if (item.classList.contains("active")) {
//         item.classList.remove("active");
//       }
//     });

//     e.target.classList.add("active");
//   } else if (e.target.nodeName == "LI" || e.target.nodeName == "I") {
//     console.info("nodename");

//     items.forEach(function (item) {
//       // console.info(item);
//       if (item.classList.contains("active")) {
//         item.classList.remove("active");
//       }
//     });

//     e.target.parentElement.classList.add("active");
//   }
// });

let sideBarItem = document.querySelector(".sidebar");
let items = document.querySelectorAll(".item");

// HALAMAN
let pageBarang = document.getElementById("page-barang");
let pagePembelian = document.getElementById("page-pembelian");
let pageCekHarga = document.getElementById("page-cek-harga");

sideBarItem.addEventListener("click", function (e) {
  // console.info(e);
  if (e.target.className == "item") {
    console.info("item");

    items.forEach(function (item) {
      if (item.classList.contains("active")) {
        item.classList.remove("active");
      }
    });

    e.target.classList.add("active");

  } else if (e.target.nodeName == "LI" || e.target.nodeName == "I") {
    // console.info("nodename");

    items.forEach(function (item) {
      // console.info(item);
      if (item.classList.contains("active")) {
        item.classList.remove("active");
        // console.info(1);
      } 
    });

    e.target.parentElement.classList.add("active");
  }
});





let themeBtn = document.querySelector(".button-dark-theme");

themeBtn.addEventListener("click", function () {
  document.body.classList.toggle("dark-theme");
});

let barMenu = document.getElementById("bar-menu");
let container = document.querySelector(".container");
let sideBarUl = document.querySelector(".sidebar ul");

barMenu.onclick = function (e) {
  console.info(e);
  if (container.classList.contains("active")) {
    container.classList.remove("active");
    container.style.transition = "300ms";
    // container.style.transition = "300ms ease 1s";
    // container.style.transition = "300ms";
    setTimeout(function () {
      const element = document.getElementsByClassName("container")[0];
      const attr = element.getAttributeNode("style");
      element.removeAttributeNode(attr);
    }, 500);
    sideBarUl.classList.remove("active");
  } else {
    container.classList.add("active");
    sideBarUl.classList.add("active");
  }
};
