export default [
    { path: "/", component: require("../components/Redirect.vue") },
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
                path: "me",
                component: require("../components/Index-UserPage.vue")
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
            },
            {
                path: "customCourse/:customCourseId",
                component: require("../components/CustomCourse.vue")
            },
            {
                path: "result/:resultId",
                component: require("../components/Index-Result.vue")
            }
        ]
    }
]
