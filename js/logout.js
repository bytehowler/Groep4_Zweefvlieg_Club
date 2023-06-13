export function logOut() {
    document.cookie = "username=session_token; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/Groep4_Zweefvlieg_Club;";
    window.location.href = "./";
}