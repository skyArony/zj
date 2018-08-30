export default [
    // { path: "/", redirect: "/index/task" },
    {
        path: "/index",
        component: require("../components/Index.vue"),
        children: [
            {
                path: "",
                redirect: "task"
            },
            {
                path: "task",
                component: require("../components/Index-TaskPage.vue")
            },
            {
                path: "team",
                component: require("../components/Index-TeamPage.vue")
            },
            {
                path: "course",
                component: require("../components/Index-CoursePage.vue")
            },
            {
                path: "video/course/:courseId",
                component: require("../components/Index-Video.vue")
            },
            {
                path: "video/customCourse/:courseId",
                component: require("../components/Index-Video.vue")
            },
            {
                path: "task/:taskId",
                component: require("../components/Index-Task.vue")
            }
        ]
    }
]
