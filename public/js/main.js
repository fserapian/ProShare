// dropdown
const elems1 = document.querySelectorAll('.dropdown-trigger');
const instances1 = M.Dropdown.init(elems1);

// select
const elems2 = document.querySelectorAll('select');
const instances2 = M.FormSelect.init(elems2);

// sidenav
const elems3 = document.querySelectorAll('.sidenav');
const instances3 = M.Sidenav.init(elems3);

// remove flash message after 3 seconds
const flashMsg = document.getElementById('msg-flash');
if (flashMsg !== null) {
    setTimeout(() => flashMsg.remove(), 4000);
}

// ajax logic
function react(type, postId) {

    const tup = document.getElementById('tup');
    const tdown = document.getElementById('tdown');

    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
        if (xhr.status === 200) {

            let responseObj = null;
            try {
                responseObj = JSON.parse(xhr.responseText);
                console.log(responseObj);

                if (type === -1) {

                    tdown.style.color = '#1e88e5';
                    tup.style.color = '#000';
                    numdown.style.color = '#1e88e5';
                    numup.style.color = '#000';

                } else {
                    tup.style.color = '#1e88e5';
                    tdown.style.color = '#000';
                    numup.style.color = '#1e88e5';
                    numdown.style.color = '#000';
                }
            } catch (e) {
                console.error('Could not parse JSON!');
            }

            if (responseObj) {
                handleResponse(responseObj);
            }
        }
    }

    xhr.open('post', `http://localhost:8080/postshare/posts/react/${type}/${postId}`, true);

    xhr.send();
}

// handle response
function handleResponse(response) {

    const numup = document.getElementById('numup');
    const numdown = document.getElementById('numdown');

    if (response.type === 1) {
        numdown.textContent = response.dislikes;
        numup.textContent = response.likes;
    } else {
        numup.textContent = response.likes;
        numdown.textContent = response.dislikes;
    }
}

// go to show page
function loadShowPage(location) {
    window.location = location;
}



