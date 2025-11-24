# Scalable Web Application with ALB, Auto Scaling, and RDS

This project demonstrates a **highly available and scalable PHP web application** deployed on AWS. It uses EC2 instances behind an Application Load Balancer (ALB), an Auto Scaling Group (ASG), and an optional Multi-AZ RDS MySQL database for backend storage.

<img width="1338" height="405" alt="diagram-export-24-11-2025-17_28_43" src="https://github.com/user-attachments/assets/ea8b7bd1-a1d0-4f31-a31f-d3edd577313c" />

---

## Architecture Overview

1. **VPC & Subnets**  
   - Two **public subnets** for ALB and EC2 instances.  
   - Two **private subnets** for RDS database.  

2. **EC2 Auto Scaling Group**  
   - Launches EC2 instances running Apache and PHP automatically via user data.  
   - Auto Scaling adjusts the number of instances based on traffic.  

3. **Application Load Balancer (ALB)**  
   - Distributes incoming HTTP traffic across EC2 instances.  
   - Monitors health of instances via a target group.  

4. **Amazon RDS (Multi-AZ)**  
   - MySQL database in private subnets.  
   - EC2 instances connect securely using a security group and credentials stored in **Secrets Manager**.  

5. **Secrets Manager**  
   - Stores database credentials securely.  
   - EC2 user-data retrieves the credentials on startup.  

6. **CloudWatch & IAM**  
   - IAM roles allow EC2 instances to access AWS resources.  
   - CloudWatch can monitor metrics and send alerts via SNS (optional).  

---

## Web Application

The PHP application (`index.php`) deployed on EC2:

- Connects to the RDS database.  
- Creates a `visitors` table if it does not exist.  
- Logs each page visit.  
- Displays the total number of visits and the hostname of the serving EC2 instance.  

This allows you to **test load balancing**, as multiple instances behind the ALB increment the visitor count separately.

---

### Local Testing (Optional)

You can run the PHP app locally for quick testing:

```bash
php -S localhost:8080 -t app/
# Open http://localhost:8080 in your browser
```
---
### Deployment
Deploy the infrastructure using the provided CloudFormation template:
```bash
pip install -r requirements.txt        # Install Python dependencies
cfn-lint infrastructure.yaml          # Validate the template
aws cloudformation deploy \
    --template-file infrastructure.yaml \
    --stack-name scalable-web-app \
    --capabilities CAPABILITY_IAM \
    --parameter-overrides KeyName=YOUR_KEY
```
---
### Notes

- EC2 instances run Amazon Linux 2 with Apache and PHP installed via user data.

- Auto Scaling ensures high availability and scales EC2 instances based on demand.

- RDS is deployed in Multi-AZ mode for resilience.

- The PHP app automatically retrieves DB credentials from Secrets Manager.

- For production, the PHP code can be hosted in S3 or Git, allowing updates without modifying the template.
---
### License

MIT
