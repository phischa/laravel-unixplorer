export interface Auth {
    user: User;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Course {
    id: number;
    name: string;
    category: string | null;
    rating: number;
    created_at: string;
    updated_at: string;
}

export interface University {
    id: number;
    name: string;
    country: string;
    homepage: string | null;
    created_at: string;
    updated_at: string;
    courses_count?: number;
    courses_avg_rating?: number | null;
    courses?: Course[];
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface PaginatedUniversities {
    data: University[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
    links: PaginationLink[];
}

export interface Filters {
    search?: string;
    course?: string;
    rating?: boolean;
}

export interface Flash {
    success?: string;
    error?: string;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    flash: Flash;
};