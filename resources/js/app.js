import "./bootstrap";

// tell vite about our images directory
import.meta.glob(["../images/**"]);

// show option list

const lists = document.querySelectorAll(".list");

// المستمع للحدث على عنصر القائمة
lists.forEach((list) => {
    list.addEventListener("click", function (e) {
        e.stopPropagation(); // منع تفعيل مستمع الحدث على الوثيقة
        list.nextElementSibling.classList.toggle("sr-only");
        list.nextElementSibling.classList.toggle("translate-x-1/4");
    });
});

// المستمع للحدث على عنصر الوالد

lists.forEach((list) => {
    list.parentElement.addEventListener("click", function (e) {
        if (e && e.stopPropagation()) e.stopPropagation();
        list.nextElementSibling.classList.add("sr-only");
    });
});

// المستمع للحدث على الوثيقة بأكملها
// التحقق مما إذا كان النقر خارج العنصر المفتوح
document.addEventListener("click", function (e) {
    lists.forEach((list) => {
        if (
            !list.contains(e.target) &&
            !list.nextElementSibling.contains(e.target)
        ) {
            list.nextElementSibling.classList.add("sr-only");
        }
    });
});

const deleteButtons = document.querySelectorAll(".btn-delete");

deleteButtons.forEach((btnDelete) => {
    btnDelete.addEventListener("click", function (e) {
        return confirm("Are you sure you want to delete");
    });
});
