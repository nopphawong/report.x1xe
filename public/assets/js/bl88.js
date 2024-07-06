async function reqPost(url, data = {}) {
    let myHeaders = new Headers()
    myHeaders.append("Content-Type", "application/json")

    let raw = JSON.stringify(data)

    let requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: raw,
        redirect: 'follow'
    }

    let response = await fetch(url, requestOptions)
    try {
        return await response.json()
    } catch (error) {
        return { status: false, message: error }
    }
}