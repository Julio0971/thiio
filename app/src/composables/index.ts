import { useStore } from '../store'

export const useFetch = async (method: 'get' | 'post' | 'put' | 'delete', url: string, body: object = {}) => {
    const store = useStore()
    
    const response = await fetch(`${import.meta.env.VITE_API_URL}${url}`, {
        method,
        body: method == 'get' ? undefined : JSON.stringify(body),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${store.access_token}`
        },
    })
    
    const res = await response.json()

    return { response, res }
}