<!DOCTYPE html>
<html>
<head>
    <title>Add and Remove Element</title>
</head>
<body>
    <div id="container">
        <!-- Elements will be added here -->
    </div>
    <button id="addButton" onclick="addElement()">Add Element</button>
    
    <script>
        // Function to add an element
        let count = 0
        function addElement() {

            var container = document.getElementById('container');
            var newElement = document.createElement('div');
            newElement.textContent = count;
            container.appendChild(newElement);
            
            // Create a remove button for the new element
            var removeButton = document.createElement('button');
            removeButton.textContent = 'Remove';
            removeButton.onclick = function() {
                container.removeChild(newElement);
            };
            newElement.appendChild(removeButton);
            count ++;
        }
        
        // Add an event listener to the "Add Element" button
    </script>
</body>
</html>