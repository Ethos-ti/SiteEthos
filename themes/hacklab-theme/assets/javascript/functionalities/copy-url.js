document.addEventListener("DOMContentLoaded", function () {
    let copy = document.querySelector('.copy');

    if (copy) {
        copy.addEventListener('click', (e) => {

            e.preventDefault();

            var content = document.getElementById('url').value;
            navigator.clipboard.writeText(content)
                .then(() => {
                    document.querySelector('#alert').textContent = "Link copied successfully!";
                })
                .catch(err => {
                    document.getElementById('alert').textContent = "Something went wrong.";
                });

            document.getElementById('alert').classList.remove("hide");
            setTimeout(function () {
                document.getElementById('alert').classList.add("hide");
                document.querySelector('#alert').textContent = "";
            }, 2000);
        });
    }
});
