export const useFetch = async (method: 'get' | 'post' | 'delete', url: string, body: object = {}) => {
    const response = await fetch(`${import.meta.env.VITE_API_URL}${url}`, {
        method,
        body: method == 'get' ? undefined : JSON.stringify(body),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
    })
    
    const res = await response.json()

    return { response, res }
}