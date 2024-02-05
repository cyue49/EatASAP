
const delBtns = document.getElementsByClassName("fa-trash-alt");
const loginBtnTxt = document.getElementById("login").getElementsByTagName("p")[0];
const allEditProfileBtn = document.querySelectorAll("main .retaurant-card .edit-btn");
const formSection = document.getElementById("form-section");
const form = document.getElementById("form");
const submitBtn = document.getElementById("submit-btn");
const log = document.getElementById("login");
//debugger;
document.addEventListener('DOMContentLoaded', function () {
    addMenuItems();
    
    //delete events
    const allDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of allDelBtn) {
            btn.addEventListener("click", delCard);
        }
    //debugger;    
    //edit Profile events
    for (let epbtn of allEditProfileBtn) {
        epbtn.addEventListener("click", function() {
            window.location.href = '../../signup.html';
        });
    }

    //edit item event
    const allEditItemBtn = document.querySelectorAll("main .card .edit-btn");
    for (let eibtn of allEditItemBtn) {
        eibtn.addEventListener("click", editCard);
        
    }
    
});

document.addEventListener('DOMContentLoaded', function () {

    const isLogin = true; //localStorage.getItem('signedIn') === 'true';
    login(isLogin);

    log.addEventListener('click', function () {

        const currentStatus = localStorage.getItem('signedIn') === 'true';
        localStorage.setItem('signedIn', String(!currentStatus));
        login(!currentStatus);

    });
});

form.addEventListener("submit", addCard);

document.addEventListener('DOMContentLoaded', popUpAddItem);

function popUpAddItem() {
    var addButton = document.getElementById('add-btn');
    var overlay = document.querySelector('.overlay');
    var overlayBg = document.querySelector('.overlay-bg');

    addButton.addEventListener('click', function () {
        overlay.style.display = 'flex';
        overlayBg.style.display = 'flex';
    });

    // close the pop-up window
    var closeButton = document.querySelector('.close-btn');
    closeButton.addEventListener('click', function () {
        overlay.style.display = 'none';
        overlayBg.style.display = 'none';
    });
}
//work here
function popUpEditItem(event) {
    event.preventDefault();

    var addButton = document.getElementById('add-btn');
    var overlay = document.querySelector('.overlay');
    var overlayBg = document.querySelector('.overlay-bg');

    addButton.addEventListener('click', function () {
        overlay.style.display = 'flex';
        overlayBg.style.display = 'flex';
    });
    const title = document.getElementById("title").value;
    const price = document.getElementById("price").value;
    const description = document.querySelector("textarea").value;

    // close the pop-up window
    var closeButton = document.querySelector('.close-btn');
    closeButton.addEventListener('click', function () {
        overlay.style.display = 'none';
        overlayBg.style.display = 'none';
    });
}

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
            <div class="edit-btn">
                <i class='far fa-edit' style='color: var(--secondary-color)'></i>
            </div>
            <div class="del-btn">
                <i class="fas fa-trash-alt" style="font-size:24px"></i>
            </div>
        </div>`;

        const parentContainer = document.getElementById('newmenulist');
        parentContainer.appendChild(listItem);
    });

}

function login(isLogin) {
    if (loginBtnTxt.textContent === "Sign In") {
        loginBtnTxt.textContent = "Sign Out";
        // for (let btn of delBtns) {
        //     btn.parentElement.style.display = "inline";
        // }
        //formSection.style.display = "block";
    } else {
        loginBtnTxt.textContent = "Sign In";
        window.location.href = '../../index.html';
        // for (let btn of delBtns) {
        //     btn.parentElement.style.display = "none";
        // }
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
    const description = document.querySelector("textarea").value;
    const imageSrc = "../../assets/pictures/comingSoon.jpg"


    const listItem = document.createElement('li');
    listItem.classList.add('card');

    // Set the inner HTML for the li element
    listItem.innerHTML = `
        <img class="item-image" src="${imageSrc}" alt="Item Picture1">
        <div class="text">
            <h3 class="i-title">${title}</h3>
            <p class="i-description">${description}</p>
            <h3 class="i-price">$${price}</h3>
        </div>
        <div class="buttons">
            <div class="edit-btn">
                <i class='far fa-edit' style='color: var(--secondary-color)'></i>
            </div>
            <div class="del-btn">
                <i class="fas fa-trash-alt" style="font-size:24px"></i>
            </div>
        </div>`;

    const parentContainer = document.getElementById('newmenulist');
    parentContainer.appendChild(listItem);

    const realDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of realDelBtn) {
            btn.addEventListener("click", delCard);
        }
    //edit events
    const allEditBtn = document.querySelectorAll("main .card .edit-btn");
    for (let btn of allEditBtn) {
            btn.addEventListener("click", editCard);
    }

    // Clear input fields
    document.getElementById("title").value = '';
    document.getElementById("price").value = '';
    document.querySelector("textarea").value = '';
}

function editCard () {
    popUpAddItem();
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
