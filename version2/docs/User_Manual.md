# คู่มือการใช้งานระบบ Research Information Management System

## 1. เปลี่ยนภาษาได้ตลอดเวลา (Switch Language at All Time)

### ภาพรวม
ฟีเจอร์นี้ช่วยให้ผู้ใช้สามารถเปลี่ยนภาษาของระบบได้ทุกเมื่อ เพื่อเพิ่มความสะดวกในการใช้งาน

### ข้อกำหนดเบื้องต้น
- สามารถใช้ได้ทั้งผู้ที่เข้าสู่ระบบแล้วและยังไม่ได้เข้าสู่ระบบ
- ระบบรองรับ 3 ภาษา:
  - ภาษาอังกฤษ (English)
  - ภาษาไทย (Thai)
  - ภาษาจีน (Chinese)
- ค่าเริ่มต้นของระบบคือภาษาอังกฤษ (English)

### วิธีใช้งาน
1. ไปที่มุมขวาบนของหน้าจอ
2. คลิกที่ไอคอนเปลี่ยนภาษา ซึ่งจะแสดงเป็น Drop-down รายการภาษาพร้อมธงประจำประเทศ
3. เลือกภาษาที่ต้องการ:
   - English (ค่าเริ่มต้น)
   - Thai
   - Chinese
4. ระบบจะอัปเดตชื่อเมนูและหัวข้อที่เกี่ยวข้องกับระบบเป็นภาษาที่เลือก

### ข้อจำกัด
- **ภาษาจีน (Chinese):** รองรับเฉพาะการแปลชื่อเมนูและหัวข้อหลักเท่านั้น
- เนื้อหาที่เกี่ยวข้องกับ Paper หรือข้อมูลจากฐานข้อมูลจะแสดงเป็นภาษาอังกฤษหรือไทย (ขึ้นอยู่กับข้อมูลที่ดึงมาได้)

---

## 2. การดู Log ของระบบ (View System Log)

### ภาพรวม
ฟีเจอร์นี้ช่วยให้ผู้ดูแลระบบสามารถดูบันทึกการทำงานของระบบ เช่น การเข้าสู่ระบบ การออกจากระบบ ข้อผิดพลาด และการเปลี่ยนแปลงข้อมูล

### ข้อกำหนดเบื้องต้น
- ผู้ใช้ต้องมีสิทธิ์เป็น **Admin**
- ต้องเข้าสู่ระบบด้วยบัญชีที่มีสิทธิ์

### วิธีใช้งาน

#### 1. จากหน้า Dashboard
1. ไปที่หน้า **Dashboard** (หน้าแรก)
2. ตรวจสอบ Logs โดยรวมทั้งหมดของระบบ พร้อมการแจ้งเตือน Logs ที่สำคัญ ได้แก่:
   - **API ถูกเรียกเกินจำนวนที่กำหนด:** การเรียก API ติดต่อเกิน 5 ครั้งใน 1 นาที
   - **การล็อกอินผิดพลาดหลายครั้ง:** IP ที่พยายามเข้าสู่ระบบติดต่อเกิน 5 ครั้งใน 1 นาที
3. กำหนดวันที่ จากนั้นกด **Apply** เพื่อค้นหา Log ในช่วงเวลาที่ต้องการ
4. ตรวจสอบสถานะของผู้ใช้:
   - **User Active:** แสดงจำนวนผู้ใช้งานออนไลน์ในขณะนั้น
   - **จำนวนผู้ใช้ทั้งหมด:** แสดงจำนวนบัญชีผู้ใช้ทั้งหมดในระบบ (กดเพื่อไปยังหน้า **User** ในเมนู Admin)
   - **จำนวนงานวิจัยทั้งหมด:** แสดงจำนวนงานวิจัยในระบบ (กดเพื่อไปยังหน้า **Manage Publications** ในเมนู Admin)
   - **จำนวนครั้งการเข้าสู่ระบบในวันนี้:** กดเพื่อไปยังหน้า **Logs** พร้อมฟิลเตอร์ Log ด้วย **Login**
   - **จำนวนการเรียก API ในวันนี้:** กดเพื่อไปยังหน้า **Logs** พร้อมฟิลเตอร์ Log ด้วย **Call Paper**
5. ตรวจสอบ Log ที่ต้องตรวจสอบเพิ่มเติม โดยกดเพื่อเข้าสู่ Log นั้นๆ ในหน้า **Logs** ของเมนู Admin
6. ดู **HTTP Error Docs** เพื่อดูความหมายของรหัส HTTP ต่างๆ

#### 2. จากหน้า Logs
1. ไปที่หน้า **Logs** ในเมนู Admin
2. ตาราง Log จะแสดงข้อมูล เช่น วันที่ เวลา อีเมล และประเภทกิจกรรม
3. ใช้ฟังก์ชัน **Sort by Date** และ **Filter** เพื่อค้นหาข้อมูลที่ต้องการ

### การแก้ไขปัญหา
**ปัญหา:** ไม่พบ Log ที่ต้องการ
- รีเฟรชหน้าเว็บ
- ตรวจสอบว่าผู้ใช้มีสิทธิ์ดู Log

---

**อัปเดตล่าสุด:** 25 กุมภาพันธ์ 2025

