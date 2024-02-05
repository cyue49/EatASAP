
const delBtns = document.getElementsByClassName("fa-trash-alt");
const loginBtnTxt = document.getElementById("login").getElementsByTagName("p")[0];
const formSection = document.getElementById("form-section");
const form = document.getElementById("form");
const submitBtn = document.getElementById("submit-btn");
const log = document.getElementById("login");

document.addEventListener('DOMContentLoaded', function () {
    //sessionStorage.setItem("noOfItems", 0);
    addMenuItems();

    //delete events
    const allDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of allDelBtn) {
        btn.addEventListener("click", delCard);
    }

    //Basket badge number and color
    const cartLink = document.querySelectorAll('.submit-btn');
    const badge = document.querySelector('.custom-badge');

    let count = 0;
    for (let item of cartLink) {
        item.addEventListener('click', function () {
            count++;
            badge.textContent = count;
            sessionStorage.setItem("item",item);

            if (count > 0) {
                badge.classList.add('orange-color');
            } else {
                badge.classList.remove('orange-color');
            }
        });
    } 

    });

document.addEventListener('DOMContentLoaded', function () {

    log.addEventListener('click', function () {

        const currentStatus = localStorage.getItem('signedIn') === 'true';
        localStorage.setItem('signedIn', String(!currentStatus));
        login(!currentStatus);

    });
});

form.addEventListener("submit", addCard);

//document.addEventListener('DOMContentLoaded', popUpAddItem);

// function popUpAddItem() {
//     var addButton = document.getElementById('add-btn');
//     var overlay = document.querySelector('.overlay');
//     var overlayBg = document.querySelector('.overlay-bg');

//     addButton.addEventListener('click', function () {
//         overlay.style.display = 'flex';
//         overlayBg.style.display = 'flex';
//     });

//     // close the pop-up window
//     var closeButton = document.querySelector('.close-btn');
//     closeButton.addEventListener('click', function () {
//         overlay.style.display = 'none';
//         overlayBg.style.display = 'none';
//     });
// }

function showTab(tabId) {
    //debugger;
    // Hide all tabs headers and contents and reset content tab
    const newMenuList = document.getElementById('newmenulist');
    newMenuList.innerHTML = '';
    const tabContents = document.querySelectorAll('.tab-content');
    const tabHeaders = document.querySelectorAll('.tab-head');
    tabContents.forEach(tabContent => {
        tabContent.classList.remove('active');
    });
    tabHeaders.forEach(tabHeader => {
        tabHeader.classList.remove('active');
    });

    // Show the selected tab and line under tab header
    const selectedTab = document.getElementById(tabId);
    const index = tabId.charAt(tabId.length - 1);
    const tabHeaderID = "tab-head" + index;
    const selectedTabHeader = document.getElementById(tabHeaderID);
    if (selectedTab) {
        selectedTab.classList.add('active');
        selectedTabHeader.classList.add('active');
    }
    //debugger;
    addMenuItems();
}


// Create a new li element
function addMenuItems() {
    const menuItems = [
        {
            title: "Grilled Salmon Steak",
            description: "Salmon steak marinated in herbs and grilled to perfection.",
            price: "$18.75",
            imageSrc: "../../assets/pictures/PlatesPictures/plate4.jpg",
        },
        {
            title: "Vegetarian Pad Thai",
            description: "Stir-fried rice noodles with tofu, bean sprouts, and peanuts.",
            price: "$11.95",
            imageSrc: "../../assets/pictures/PlatesPictures/plate5.jpg",
        },
        {
            title: "Classic Margherita Pizza",
            description: "Tomato sauce, fresh mozzarella, basil, and olive oil on a thin crust.",
            price: "$14.50",
            imageSrc: "../../assets/pictures/PlatesPictures/plate6.jpg",
        },
    ];

    menuItems.forEach((item) => {
        const listItem = document.createElement('li');
        listItem.classList.add('card');

        // Set the inner HTML for the li element
        listItem.innerHTML = `
        <img class="item-image" src="${item.imageSrc}" alt="Item Picture1">
        <div class="text">
            <h3 class="i-title">${item.title}</h3>
            <p class="i-description">${item.description}</p>
            <h3 class="i-price">${item.price}</h3>
        </div>
        <div class="buttons">
            <div >
                <button id="add-btn" class="submit-btn">Add</button>
            </div>
        </div>`;

        const parentContainer = document.getElementById('newmenulist');
        parentContainer.appendChild(listItem);
    });

}

function login(isLogin) {
    if (loginBtnTxt.textContent === "Sign In") {

        loginBtnTxt.textContent = "Sign Out";
        window.location.href = '../../signin.html';
    } else {
        loginBtnTxt.textContent = "Sign In";
        formSection.style.display = "none";
    }
}

function delCard(event) {
    event.currentTarget.parentElement.parentElement.remove();
}

function addCard(event) {
    event.preventDefault();

    const title = document.getElementById("title").value;
    const price = document.getElementById("price").value;

    const listItem = document.createElement('li');
    listItem.classList.add('summary');

    // Set the inner HTML for the li element
    listItem.innerHTML = `
        <div class="text">
            <h3 class="i-title">${title}</h3>
            <h3 class="i-price">$${price}</h3>
        </div>`;

    const parentContainer = document.getElementById('summary');
    parentContainer.appendChild(listItem);

    const realDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of realDelBtn) {
        btn.addEventListener("click", delCard);
    }

}


// Helper functions to avoid repetition.

function createSimpleNode(element, classes) {
    const simpleEle = document.createElement(element);
    simpleEle.className = classes;
    return simpleEle;
}

function createNodeWithText(element, content, classes) {
    const ele = createSimpleNode(element, classes);
    ele.textContent = content;
    return ele;
}
