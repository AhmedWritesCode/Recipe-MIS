document.addEventListener('DOMContentLoaded', () => {
    const loadRecipes = () => {
        const sortBy = document.getElementById('sort-by').value;
        const order = document.getElementById('order').value;
        const category = document.getElementById('category-filter').value;
        const ingredient = document.getElementById('ingredient-filter').value;

        fetch(`my_recipes.php?sort_by=${sortBy}&order=${order}&category=${category}&ingredient=${ingredient}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(recipes => {
                const recipesContainer = document.getElementById('recipes');
                recipesContainer.innerHTML = '';
                recipes.forEach(recipe => {
                    const recipeCard = document.createElement('div');
                    recipeCard.className = 'recipe-card';
                    
                    const title = document.createElement('h2');
                    title.textContent = recipe.title;
                    
                    const category = document.createElement('p');
                    category.textContent = `Category: ${recipe.category}`;
                    
                    const ingredients = document.createElement('p');
                    ingredients.textContent = `Ingredients: ${recipe.ingredients}`;
                    
                    const steps = document.createElement('p');
                    steps.textContent = `Steps: ${recipe.steps}`;

                    const favouriteButton = document.createElement('button');
                    favouriteButton.className = 'btn';
                    favouriteButton.innerHTML = 'Add to Favourites';
                    favouriteButton.addEventListener('click', () => {
                        fetch('favourite_recipe.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ recipeId: recipe.id })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response from server:', data); 
                            if (data.success) {
                                favouriteButton.textContent = '⭐Favourite⭐';
                                favouriteButton.disabled = true;
                            } else {
                                alert('Failed to mark as favourite: ' + data.error);
                            }
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                    });

                    const editButton = document.createElement('a');
                    editButton.className = 'btn';
                    editButton.textContent = 'Edit';
                    editButton.href = `edit_recipe.html?id=${recipe.id}`; 

                    const deleteButton = document.createElement('a');
                    deleteButton.className = 'btn';
                    deleteButton.textContent = 'Delete';
                    deleteButton.href = `delete_recipe.php?id=${recipe.id}`; 

                    recipeCard.appendChild(title);
                    recipeCard.appendChild(category);
                    recipeCard.appendChild(ingredients);
                    recipeCard.appendChild(steps);
                    recipeCard.appendChild(favouriteButton);
                    recipeCard.appendChild(editButton);
                    recipeCard.appendChild(deleteButton);
                    
                    recipesContainer.appendChild(recipeCard);
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    };

    // Load recipes on page load
    loadRecipes();

    // Add event listeners for sorting and filtering
    document.getElementById('sort-by').addEventListener('change', loadRecipes);
    document.getElementById('order').addEventListener('change', loadRecipes);
    document.getElementById('filter-btn').addEventListener('click', loadRecipes);
});
