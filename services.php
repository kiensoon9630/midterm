<?php
session_start();

include('dbconnect.php'); // Include database connection file first

if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
    echo "<script>alert('Please Login')</script>";
    echo "<script>window.location.href = 'login.php'</script>";
    exit; // Stop further execution if not logged in
}

$sql = "SELECT * FROM tbl_services";
$stmt = $conn->query($sql);

$services = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $services[] = $row;
}

$conn = null; // Close the database connection after fetching data
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>My Clinic</title>
    <style>
        .mycard {
            max-width: 350px;
            height: 100%; /* Set height to 100% to ensure cards are of equal height */
            margin: 10px;
            text-align: justify;
            display: flex;
            flex-direction: column;
        }

        .mycard img {
            max-width: 100%;
            height: auto;
        }

        .card-body {
            flex: 1; /* Allow card body to expand to fill remaining space */
        }

        body {
            font-family: Garamond, serif;
            font-size: larger;
        }

        .header-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #92bdf7; /* Indigo color */
        }

        .header-container h1 {
            font-size: calc(8px + 4vw);
            font-family: monospace;
            margin: 0;
        }

        .header-buttons {
            display: flex;
            gap: 20px;
            margin-left: auto;
            margin-right: auto;
        }

        .header-buttons a {
            padding: 20px 30px;
            font-size: 18px; /* Adjust the font size */
            font-family: monospace; /* Change the font family to Monospace */
            font-weight: bold; /* Make the font bold */
            color: black;
            text-decoration: none;
            border-radius: 4px;
        }

        .header-buttons a:hover {
            background-color: black; /* Darker blue-gray on hover */
            color: white; /* Change text color on hover */
        }

        .custom-bg-2 {
            background-color: #92bdf7;
        }
    </style>
</head>
<body>
<div class="header-container">
    <h1>MYCLINIC</h1>
    <div class="header-buttons">
        <a href="newpatient.php" class="w3-bar-item w3-button">New Patient</a>
        <a href="services.php" class="w3-bar-item w3-button">Our Services</a>
        <a href="login.php" class="w3-bar-item w3-button">Logout</a>
    </div>
</div>
<div class="w3-container w3-row w3-padding w3-center" style="margin:auto;">
    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
            <div class="w3-card w3-container w3-col mycard" onclick="showServiceDetails('<?php echo addslashes($service['service_name']); ?>', '<?php echo addslashes($service['service_description']); ?>', '<?php echo addslashes($service['service_price']); ?>', '<?php echo strval($service['service_id']); ?>')">
                    <?php
                    // Assuming 'image_path' is the column name in your database table for storing image paths
                    $service_id = $service['service_id'];
                    $service_image = $service_id . '.jpg'; // Example path assuming all images are .jpg format
                    if (!file_exists($service_image)) {
                        $service_image = 'images/default.jpg'; // Default image path if specific image is not found
                    }
                    ?>
                    <img src="<?php echo $service_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($service['service_name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo htmlspecialchars($service['service_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($service['service_description'], 0, 100)); ?>...</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="serviceDetails">
                    <!-- Service details will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showServiceDetails(serviceName, serviceDescription, servicePrice, serviceId) {
        // Update modal content with fetched details
        document.getElementById('serviceModalLabel').innerText = serviceName;
        document.getElementById('serviceDetails').innerHTML = `
            <p>Description: ${serviceDescription}</p>
            <p>Price: ${servicePrice}</p>
            <p>Additional Details:</p>
            <ul>
                ${getServiceDetails(serviceId)}
            </ul>
        `;

        // Show the modal using jQuery
        $('#serviceModal').modal('show');
    }

    function getServiceDetails(serviceId) {
    // Convert serviceId to string if it's an integer
    serviceId = String(serviceId);

    // Function to return specific additional details based on service ID
    switch (serviceId) {
        case '1':
            return `
                <strong>RM99 - Primary Care Consultation Package*</strong>
                <li>Comprehensive medical history review</li>
                <li>Physical examination by a licensed General Practitioner</li>
                <li>Discussion of current symptoms and health concerns</li>
                <li>Personalized health advice and lifestyle recommendations</li>
            `;
        case '2':
            return `
                <strong>RM149* - Dietitian Screening</strong>
                <li>Physical examination by Wellness Doctor</li>
                <li>Laboratory Test (GP59H) - Consists of 41 Test (Kidney Function Test,
                Lipid Screen, Full Blood Count, Diabetic Screening (Resting Blood Sugar),
                Urine Test, Liver Function Test</li>
                <li>Dietitian Consultation</li>
                <li>Body Composition Analysis</li>
                <strong>RM259* - BMI Screening</strong>
                <li>Physical examination by Wellness Doctor</li>
                <li>Dietitian Consultation (3 Times)</li>
                <li>Body Composition Analysis (3 Times)</li>
                <strong>Add on:</strong>
                <li>Dietitian Consultation (3 Times) - RM85</li>
            `;
            case '3':
            return `
                <strong>RM379* - Elite</strong>
                <li>Physical examination by Consultant Physician (Blood Pressure, Body Mass Index, 
                Weight, Waist Measurement, Pulse Rate & Eye Acuity Test)</li>
                <li>Chest X-Ray</li>
                <li>Electrocardiogram (ECG)</li>
                <li>Laboratory Test (GP61M) - Consist of 56 Test (Blood Glucose, Blood Group, 
                Erythrocyte Sedimentation Rate (ERS), Haematological Indices & Full Blood Court, 
                Hepatitis A & B Screening, Lipid Profile, Liver Function Test, Renal Function Test,
                 Rheumatoid Factor (RF), Urine Analysis, Thyroid TSH, Uric Acid, VDRL, Calcium)</li>
                <strong>RM1000* - Supreme</strong>
                <li>Physical examination by Consultant Physician (Blood Pressure, Body Mass Index, 
                Weight, Waist Measurement, Pulse Rate & Eye Acuity Test)</li>
                <li>Chest X-Ray</li>
                <li>Electrocardiogram (ECG)</li>
                <li>Laboratory Test (GP61M) - Consist of 56 Test (Blood Glucose, Blood Group, 
                Erythrocyte Sedimentation Rate (ERS), Haematological Indices & Full Blood Court, 
                Hepatitis A & B Screening, Lipid Profile, Liver Function Test, Renal Function Test,
                 Rheumatoid Factor (RF), Urine Analysis, Thyroid TSH, Uric Acid, VDRL, Calcium)</li>
                <li>Stress Test</li>
                <li>Ultrasound Abdomen & Pelvis</li>
                <li>Tumor Maker Test [Liver (AFP) & Colon (CEA)]</li>
            `;
            case '4':
            return `
                <strong>RM179 - Comprehensive X-ray Examination Package*</strong>
                <strong>RM179 - X-ray Examination</strong>
                <li>One standard X-ray (e.g., chest, abdomen, limbs, spine, 
                or other specific area as recommended)</li>
                <li>High-resolution imaging using advanced X-ray equipment</li>
                <li>Detailed analysis by a licensed radiologist</li>
            `;
            case '5':
            return `
                <strong>RM499 - Comprehensive MRI Examination Package*</strong>
                <strong>MRI Examination</strong>
                <li>High-resolution Magnetic Resonance Imaging (MRI) of one specified area 
                (e.g., brain, spine, joints, abdomen, etc.)</li>
                <li>Use of state-of-the-art MRI equipment for detailed imaging</li>
                <li>Option for contrast-enhanced MRI if recommended by the radiologist 
                (additional cost may apply)</li>
            `;
            case '6':
            return `
                <strong>RM299 - Comprehensive CT Scan Examination Package*</strong>
                <strong>CT Scan Examination</strong>
                <li>High-resolution Computed Tomography (CT) scan of one specified area (e.g., 
                head, chest, abdomen, pelvis, or other as recommended)</li>
                <li>Use of advanced CT imaging technology for detailed cross-sectional images</li>
                <li>Option for contrast-enhanced CT scan if recommended by the radiologist 
                (additional cost may apply)</li>
            `;
            case '7':
            return `
                <strong>RM299 - Comprehensive Ultrasound Examination Package*</strong>
                <strong>Ultrasound Examination</strong>
                <li>High-resolution ultrasound imaging of one specified area (e.g., abdomen,
                 pelvis, thyroid, breast, or other as recommended)</li>
                <li>Use of advanced ultrasound equipment for clear and detailed imaging</li>
                <li>Real-time imaging to observe the functioning and structure of organs and tissues</li>
            `;
            case '8':
            return `
                <strong>RM99 - Influenza Vaccination Package*</strong>
                <strong>Terms & Conditions:</strong>
                <li>This package is applicable under Wellness Clinic for 
                self-paying patient during office hour only.</li>
                <li>The management reserve the right to withdraw this package without any notice.</li>
            `;
            case '9':
            return `
                <strong>RM199 - Heart Screening  Package*</strong>
                <li>Physical examination by Consultant Cardiologist</li>
                <li>Chest X-Ray</li>
                <li>Electrocardiogram (ECG)</li>
                <li>Laboratory Test (GP59H) - Consists of 41 Test (Lipid Profile, Fasting Blood Sugar, 
                Full Blood Count & Kidney Function Test</li>
            `;
            case '10':
            return `
                <strong>RM139*- AUDIOMETRY PACKAGE</strong>
                <An audiometry exam tests how well your hearing functions. It tests both the 
                intensity and the tone of sounds, balance issues, and other issues related to the function of the inner ear. 
                This test are perform by our Audiologist.>
                <li>Physical examination by Wellness Doctor</li>
                <li>Pure Tone Audiometry by Audiologist</li>
                <li>Refreshment</li>
            `;
            case '11':
            return `
                <strong>SPECIAL BLOOD SCREENING PACKAGE</strong>
                <strong>RM119* - Basic</strong>
                <li>Physical examination by Wellness Doctor</li>
                <li>Laboratory Test (GP59H) - Consists of 41 Test (Kidney Function Test, 
                Lipid Screen, Full Blood Count, Diabetic Screening (fasting Blood Sugar), Urine Test, 
                Liver Function Test</li>
                <strong>RM169* - Advance</strong>
                <li>Physical examination by Wellness Doctor</li>
                <li>Laboratory Test (GP61M) - Consists of 56 Test (Blood Glucose, Blood Group, 
                Erythrocyte Sedimentation Rate (ERS), Lipid Profile, Liver Function Test, Haematological 
                Indices & Full Blood Count, Hepatitis A & B Screening, Renal Function Test, Rheumatoid Factor 
                (RF), Urine Analysis, Thyroid TSH, Uric Acid, VDRL Calcium</li>
            `;
            case '12':
            return `
                <strong>WELLNESS HEALTH SCREENING PACKAGE</strong>
                <strong>RM288* - Prime</strong>
                <li>Electrocardiogram (ECG)</li>
                <li>Chest X-Ray</li>
                <li>Physical examination by Wellness Doctor</li>
                <li>Laboratory Test (GP59H) - Consists of 41 Test (Kidney Function Test, 
                Lipid Screen, Full Blood Count, Diabetic Screening (Fasting Blood Sugar), 
                Urine Test, Liver Function Test</li>
                <strong>RM488* - Deluxe</strong>
                <li>Electrocardiogram (ECG)</li>
                <li>Chest X-Ray</li>
                <li>Physical examination by Wellness Doctor</li>
                <li>Laboratory Test (GP59H) - Consists of 41 Test (Kidney Function Test, 
                Lipid Screen, Full Blood Count, Diabetic Screening (Fasting Blood Sugar), 
                Urine Test, Liver Function Test</li>
                <li>Body Composition Analysis</li>
                <li>Dietitian Consultation</li>
                <li>Lung Function Test</li>
            `;    
        default:
            return `
                <li>No additional details available for this service.</li>
            `;
    }
}
</script>
</body>
</html>
