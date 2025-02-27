// tangkap task-list
let taksList = document.querySelectorAll('.task-list');
let taskCount = document.querySelector('.task-count');

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
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let belumSelesai = document.querySelectorAll(".status-task[value='belum']").length;
                    if (belumSelesai == 0) {
                        taskCount.innerText = `tidak ada tugas`;
                    }
                    if (belumSelesai > 0) {
                        taskCount.innerText = `${belumSelesai} tugas belum selesai`;
                    }
                }
            });

    })

    // cek task sudah atau belum
    if (taskId.value === 'sudah') {
        task.classList.add('line');
    }
});