// tangkap task-list
let taksList = document.querySelectorAll('.task-list');

taksList.forEach(task => {
    let taskId = task.querySelector('input');

    task.addEventListener('click', function () {
        task.classList.toggle('line');

        let status = (taskId.value === "belum") ? "sudah" : "belum";
        taskId.value = status;

        // kirim data ke php menggunakan fetch API
        fetch("update_task.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${task.dataset.id}&status=${status}`
        });


    })

    // cek task sudah atau belum
    if (taskId.value === 'sudah') {
        task.classList.add('line');
    }
});