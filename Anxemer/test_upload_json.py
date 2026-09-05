import requests, base64, json

AUTH = base64.b64encode(b"admin:Q5qz 5BX0 20LM uEYs 7b0i ud9n").decode()
SITE = "https://batdongsankhucongnghiep.vn"

headers = {
    "Authorization": "Basic " + AUTH,
    "Content-Disposition": "attachment; filename=bds24h-test.json",
    "Content-Type": "application/json"
}

r = requests.post(f"{SITE}/wp-json/wp/v2/media", headers=headers, data=b'{"status": "ok"}')
print("Upload status:", r.status_code)
if r.status_code in (200, 201):
    print("Source url:", r.json().get("source_url"))
