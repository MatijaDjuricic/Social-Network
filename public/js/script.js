if (window.location.pathname == '/Social_NetworkOOP/edit_profile.php') {
    let base_input_content = document.querySelector('.email-field');
    let input_content = document.querySelector('.email-field').getAttribute('data-content');
    let display_email_format = input_content.replace(input_content.slice(3, input_content.indexOf('@')), input_content.slice(3, input_content.indexOf('@')).replace(/[A-Za-z0-9]/g, '*'));
    base_input_content.value = display_email_format;
}
const openOverlay = btn => {
    let overlay = btn.nextElementSibling;
    overlay.style.display = "block";
}
const closeOverlay = btn => {
    let overlay = btn.parentElement.parentElement.parentElement;
    if (btn.getAttribute('id') == "wf") {
        let form_overlay = btn.parentElement.parentElement.parentElement.parentElement;
        let form_input = btn.parentElement.previousElementSibling;
        form_input.value = form_input.getAttribute('data-id');
        form_overlay.style.display = "none";
    } else overlay.style.display = "none";
}
const commentPost = btn => {
    let div = document.querySelectorAll('.post-comments');
    let id_btn = btn.getAttribute('data-post_id');
    div.forEach(element => {
        let id_div = element.getAttribute('data-post_id');
        if (id_btn == id_div) {
            element.classList.toggle('display');
            let btn_comment = btn.querySelector('i');
            btn_comment_class = btn_comment.getAttribute('class');
            btn_title = btn.getAttribute('title');
            if (btn_comment_class == "fa-solid fa-comment-dots" && btn_title == "Open Comments") {
                btn_comment.setAttribute("class", "fa-solid fa-comment-slash");
                btn.setAttribute("title", "Close Comments");
            } else {
                btn_comment.setAttribute("class", "fa-solid fa-comment-dots");
                btn.setAttribute("title", "Open Comments");
            }
        }
    });
}