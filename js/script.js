// tangkap task-list

let taksList = document.querySelectorAll('.task-list');
console.log(taksList);
taksList.forEach(task => {
    task.addEventListener('click', function () {
        task.classList.toggle('line');
    })
});