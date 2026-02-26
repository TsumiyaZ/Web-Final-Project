with open("views\detailEvent.php", "r", encoding="utf-8") as f:
    lines = f.readlines()

# เก็บเฉพาะบรรทัดที่ไม่ว่าง
cleaned = [line for line in lines if line.strip() != ""]

with open("detailEvent1.php", "w", encoding="utf-8") as f:
    f.writelines(cleaned)

print("ลบบรรทัดว่างเรียบร้อยแล้ว")