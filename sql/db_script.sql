-- create database
create database kung_noodle_db;

-- create employee table
create table employee (
    employee_id int auto_increment,
    emp_name varchar(80),
    role varchar(40),
    password varchar(20),    
    salary float,
    branch int,
    primary key (employee_id)   
    );

-- create ingredeint table
create table ingredient ( 
    ingredient_id int auto_increment, 
    ingredient_name varchar(80), 
    unit varchar(20), 
    cost_per_unit float, 
    employee_id int, 
    update_time datetime, 
    primary key (ingredient_id), 
    constraint foreign key (employee_id) references employee(employee_id) on delete RESTRICT
    );

-- create menu table
create table menu ( 
    menu_id int auto_increment, 
    menu_name varchar(80),     
    price float, 
    branch_available int,
    employee_id int, 
    update_time datetime, 
    primary key (menu_id), 
    constraint foreign key (employee_id) references employee(employee_id) on delete RESTRICT
    );

-- create recipe table
create table recipe (
    menu_id int,
    ingredient_id int,
    amount float,
    unit varchar(20),
    primary key (menu_id, ingredient_id),
    constraint foreign key (menu_id) references menu(menu_id) on delete RESTRICT, 
    constraint foreign key (ingredient_id) references ingredient(ingredient_id) on delete RESTRICT
);


-- create order_table
create table order_table (
    order_id int auto_increment,
    order_date date,
    order_time time,
    place varchar(20),
    order_status varchar(20),
    employee_id int,
    update_time datetime,
    primary key (order_id),
    constraint foreign key (employee_id) references employee(employee_id) on delete RESTRICT
);

-- create order_detail table
create table order_detail(
    order_id int,
    menu_id int, 
    description text(200),
    quantity int,
    primary key (order_id, menu_id),
    constraint foreign key (order_id) references order_table(order_id) on delete RESTRICT,
    constraint foreign key (menu_id) references menu(menu_id) on delete RESTRICT 
);

-- insert admin user account
insert into employee (emp_name, role, password, branch)  values ('admin_admin', 'admin', 'admin1234', 1);

-- insert employee data
insert into employee (emp_name, role, branch, salary, password)  values 
    ('A', 'manager', 1, 30000, 'manager'),
    ('B', 'owner', 1, 40000, 'owner'),
    ('C', 'staff', 1, 16000, 'password'),
    ('D', 'staff', 1, 13000, 'password'),
    ('E', 'staff', 1, 13000, 'password'),
    ('F', 'manager', 2, 10000, 'manager'),
    ('G', 'manager', 2, 20000, 'manager'),    
    ('H', 'staff', 2, 12000, 'password');

-- insert ingredient data
insert into ingredient (ingredient_name, unit, cost_per_unit, employee_id, update_time)  values 
    ('บะหมี่','gram',1.3,1,now()),
    ('เส้นหมี่','gram',0.1,1,now()),
    ('เส้นเล็ก','gram',0.1,1,now()),
    ('เส้นใหญ่','gram',0.1,1,now()),
    ('วุ้นเส้น','gram',0.1,1,now()),
    ('มาม่า','gram',0.083333333,1,now()),
    ('เกี้ยมอี๋','gram',0.1,1,now()),
    ('ผักบุ้ง','gram',0.15,1,now()),
    ('ถั่วงอก','gram',0.15,1,now()),
    ('ลูกชิ้นปลา','piece',3.3,1,now()),
    ('ลูกชิ้นกุ้ง','piece',3.3,1,now()),
    ('ลูกชิ้นแคะ','piece',3.3,1,now()),
    ('เต้าหู้ทอด','piece',1,1,now()),
    ('เลือด','piece',1,1,now()),
    ('ปลาหมึก','piece',1.66,1,now()),
    ('เกี๊ยวทอด','piece',1.66,1,now()),
    ('ซอสเย็นตาโฟ','tabspoon',0,1,now()),
    ('ซอสต้มยำ','tabspoon',0,1,now()),
    ('นำซุป','dipper',0,1,now());

-- create view
CREATE VIEW active_order_1 AS 
SELECT * FROM order_table 
LEFT JOIN employee USING (employee_id) 
WHERE branch = 1 AND order_status != 'paid';

CREATE VIEW active_order_2 AS 
SELECT * FROM order_table 
LEFT JOIN employee USING (employee_id) 
WHERE branch = 2 AND order_status != 'paid';

CREATE VIEW order_detail_menu AS 
SELECT * FROM order_detail
LEFT JOIN menu USING (menu_id);


CREATE VIEW order_summary AS 
SELECT order_id, order_date, order_time, place, order_status, quantity, menu_id, menu_name, price , order_table.employee_id , emp_name , role , branch
FROM order_table 
LEFT JOIN order_detail USING (order_id) 
LEFT JOIN menu USING (menu_id)
LEFT JOIN employee ON employee.employee_id = order_table.employee_id
WHERE order_status = 'paid';


-- update constraint in order_detail table
ALTER TABLE order_detail DROP CONSTRAINT order_detail_ibfk_1;
ALTER TABLE order_detail DROP CONSTRAINT order_detail_ibfk_2;

ALTER TABLE order_detail
ADD CONSTRAINT order_detail_ibfk_1
FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
ON DELETE RESTRICT;

ALTER TABLE order_detail
ADD CONSTRAINT order_detail_ibfk_2
FOREIGN KEY (order_id) REFERENCES order_table(order_id)
ON DELETE RESTRICT;