export interface User {
    id: number
    name: string
    username: string
}

interface Link {
    url: string | null
    label: string
    active: boolean
}

export interface Pagination {
    current_page: number
    data: Object[]
    first_page_url: string
    from: number | null
    last_page: number
    last_page_url: string
    links: Link[]
    next_page_url: string | null
    path: string
    per_page: number
    prev_page_url: string | null
    to: number | null
    total: number
}