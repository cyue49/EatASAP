
const delBtns = document.getElementsByClassName("fa-trash-alt");
const loginBtnTxt = document.getElementById("login").getElementsByTagName("p")[0];
const formSection = document.getElementById("form-section");
const form = document.getElementById("form");
const submitBtn = document.getElementById("submit-btn");
const log = document.getElementById("login");

document.addEventListener('DOMContentLoaded', function () {
    // Use GET request to fetch session.php
    // var xhr = new XMLHttpRequest();
    // // Define the callback function to handle the response
    // xhr.onreadystatechange = function () {
    //     if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

    //         window.alert(xhr.responseText);
    //     }
    // };
    // // Open a GET request to a PHP file in the same folder
    // xhr.open("GET", "../../../Backend/session.php", true);
    // // Send the request
    // xhr.send();


    // View Menu Itemns
    addMenuItems();

    // //delete events
    // const allDelBtn = document.querySelectorAll("main .card .del-btn");
    // for (let btn of allDelBtn) {
    //     btn.addEventListener("click", delCard);
    // }


});

document.addEventListener('DOMContentLoaded', function () {

    log.addEventListener('click', function () {

        const currentStatus = localStorage.getItem('signedIn') === 'true';
        localStorage.setItem('signedIn', String(!currentStatus));
        login(!currentStatus);

    });
});

form.addEventListener("submit", addCard);

// Functions
// Ajax Add to cart
function addItemToCart(item) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../Backend/screens/menu/addToCart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            //alert(JSON.parse(xhr.responseText));
            document.getElementById("response").innerText = xhr.responseText;
        }
    };
    xhr.send(JSON.stringify(item));
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
    var menuItems;

    if (/*tabId == ""*/ false) {
        //document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xhr = new XMLHttpRequest();

        // Define the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                //Parse JSON to array of objects
                menuItems = JSON.parse(xhr.responseText);
                // Create a new li element for each item in the menuItems array    
                menuItems.forEach((item) => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('card');

                    // Set the inner HTML for the li element
                    listItem.innerHTML = `
                        <input type="hidden" class="item-id" value="${item.menu_item_id}">
                        <img class="item-image" src="${item.picture_url}" alt="Item Picture1">
                        <div class="text">
                            <h3 class="i-title">${item.item_name}</h3>
                            <p class="i-description">Ingredients: ${item.ingredient_name}</p>
                            <h3 class="i-price">$${item.price}</h3>
                        </div>
                        <div class="buttons">
                            <div >
                                <button id="add-btn" class="submit-btn">Add</button>
                            </div>
                        </div>`;

                    const parentContainer = document.getElementById('newmenulist');
                    parentContainer.appendChild(listItem);

                    

                });
                //Basket badge number and color
                const cartLink = document.querySelectorAll('.submit-btn');
                const badge = document.querySelector('.custom-badge');

                let count = 0;
                for (let item of cartLink) {
                    item.addEventListener('click', function (event) {
                        const card = event.target.closest('.card');
                        if (card) {
                            // Find the .item-id element within the .card
                            const itemID = card.querySelector('.item-id');
                            if (itemID) {
                                // Retrieve the text content of the .item-id element
                                const item_id_value = itemID.value;
                                console.log(item_id_value);

                                addItemToCart(item_id_value);
                                count++;
                                badge.textContent = count;
                                var snd = new Audio("../../assets/mixkit-correct-answer-tone-2870.wav");
                                snd.play();
                                snd.currentTime = 0;

                                if (count > 0) {
                                    badge.classList.add('orange-color');
                                } else {
                                    badge.classList.remove('orange-color');
                                }
                                // Remove the event listener to prevent multiple calls
                                //item.removeEventListener('click', this);
                            }

                        }

                    });

                }

            }
        };

        // Open a GET request to a PHP file in the same folder
        xhr.open("GET", "../../../Backend/screens/menu/getMenuItems.php", true);

        // Send the request
        xhr.send();
    }

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
