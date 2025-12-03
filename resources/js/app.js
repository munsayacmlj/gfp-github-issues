import './bootstrap';

const githubAccessToken = import.meta.env.VITE_GITHUB_ACCESS_TOKEN;

const issueBody = document.getElementById("issueBody")

if (issueBody) {
    issueBody.addEventListener("change", function (e) {
    const body = e.target.value;
    const path = window.location.pathname.split('/');
    const owner = path[2];
    const repo = path[3];
    const issueNumber = path[4];

    const params = {
        "body": body
    };
    const url = `https://api.github.com/repos/${owner}/${repo}/issues/${issueNumber}`;

    fetch(url, {
        method: "PATCH",
        body: JSON.stringify(params),
        headers: {
            "accept": "application/vnd.github+json",
            "Authorization": `Bearer ${githubAccessToken}`,
            "X-GitHub-Api-Version": "2022-11-28"
        }
    })
        .then((r) => {
            console.log(r)
        })

    });
}
