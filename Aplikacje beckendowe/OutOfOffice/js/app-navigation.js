"use strict";

(() => {
    const routes = {
        show: "../templates/show.php",
        add: "../templates/add.php",
        update: "../templates/update.php",
        delete: "../templates/delete.php",

        showProject: "../templates/showProject.php",
        project: "../templates/project.php",
        updateProject: "../templates/updateProject.php",
        deleteProject: "../templates/deleteProject.php",

        addLeaveRequest: "../templates/addLeaveRequest.php",
        showLeaveRequest: "../templates/showLeaveRequest.php",
        updateLeaveRequest: "../templates/updateLeaveRequest.php",
        deleteLeaveRequest: "../templates/deleteLeaveRequest.php",

        addApprover_Request: "../templates/addApprover_Request.php",
        showApprover_Request: "../templates/showApprover_Request.php",
        updateApprover_Request: "../templates/updateApprover_Request.php",
        deleteApprover_Request: "../templates/deleteApprover_Request.php",

        back_to_menu: "../public/menu.php",
        backToForm: "../public/logout.php"
    };

    Object.entries(routes).forEach(([elementId, url]) => {
        const element = document.getElementById(elementId);

        if (!element) {
            return;
        }

        element.addEventListener("click", () => {
            window.location.href = url;
        });

        element.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                window.location.href = url;
            }
        });
    });
})();
