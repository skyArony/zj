export default [
    { path: "/", component: require("../components/Redirect.vue") },
    {
        path: "/index",
        component: function(resolve) {
            require(["../components/Index.vue"], resolve);
        },
        children: [
            {
                path: "",
                redirect: "task"
            },
            {
                path: "task",
                component: function(resolve) {
                    require(["../components/Index-TaskPage.vue"], resolve);
                },
            },
            {
                path: "team",
                component: function(resolve) {
                    require(["../components/Index-TeamPage.vue"], resolve);
                },
            },
            {
                path: "course",
                component: function(resolve) {
                    require(["../components/Index-CoursePage.vue"], resolve);
                },
            },
            {
                path: "me",
                component: function(resolve) {
                    require(["../components/Index-UserPage.vue"], resolve);
                },
            },
            {
                path: "video/course/:courseId",
                component: function(resolve) {
                    require(["../components/Index-Video.vue"], resolve);
                },
            },
            {
                path: "video/customCourse/:courseId",
                component: function(resolve) {
                    require(["../components/Index-Video.vue"], resolve);
                },
            },
            {
                path: "task/:taskId",
                component: function(resolve) {
                    require(["../components/Index-Task.vue"], resolve);
                },
            },
            {
                path: "customCourse/:customCourseId",
                component: function(resolve) {
                    require(["../components/CustomCourse.vue"], resolve);
                },
            },
            {
                path: "result/:resultId",
                component: function(resolve) {
                    require(["../components/Index-Result.vue"], resolve);
                },
            }
        ]
    }
]
